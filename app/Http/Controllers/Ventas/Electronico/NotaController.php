<?php

namespace App\Http\Controllers\Ventas\Electronico;

use App\Almacenes\LoteProducto;
use App\Almacenes\Producto;
use App\Http\Controllers\Controller;
use App\Mantenimiento\Empresa\Numeracion;
use App\Ventas\Documento\Documento;
use App\Ventas\Nota;
use App\Ventas\NotaDetalle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Luecano\NumeroALetras\NumeroALetras;
use Yajra\DataTables\Facades\DataTables;

class NotaController extends Controller
{
    public function index($id)
    {
        $documento = Documento::find($id);
        return view('ventas.notas.index',compact('documento'));
    }

    public function getNotes()
    {
        $notas = Nota::where('tipo_nota',"1")->orderBy('id','DESC')->get();

        $coleccion = collect([]);
        foreach($notas as $nota){

            $coleccion->push([
                'id' => $nota->id,
                'documento_afectado' => $nota->numDocfectado,
                'fecha_emision' =>  Carbon::parse($nota->fecha_emision)->format( 'd/m/Y'),
                'numero-sunat' =>  $nota->serie.' - '.$nota->correlativo,
                'cliente' => $nota->tipo_documento_cliente.': '.$nota->documento_cliente.' - '.$nota->cliente,
                'empresa' => $nota->empresa,
                'monto' => 'S/. '.number_format($nota->mtoImpVenta, 2, '.', ''),
                'sunat' => $nota->sunat,
                'tipo_nota' => $nota->tipo_nota,
                'estado' => $nota->estado,
            ]);
        }
        return DataTables::of($coleccion)->toJson();
    }

    public function create($id)
    {
        $documento = Documento::findOrFail($id);
        $fecha_hoy = Carbon::now()->toDateString();
        $productos = Producto::where('estado', 'ACTIVO')->get();
        //NOTAS
        //CREDITO -> 0
        //DEBITO -> 1
        return view('ventas.notas.credito.create',[
            'documento' => $documento,
            'fecha_hoy' => $fecha_hoy,
            'productos' => $productos, 
            'tipo_nota' => '1'
        ]);

    }

    public function obtenerFecha($fecha)
    {
        $date = strtotime($fecha);
        $fecha_emision = date('Y-m-d', $date); 
        $hora_emision = date('H:i:s', $date); 
        $fecha = $fecha_emision.'T'.$hora_emision.'-05:00';

        return $fecha;
    }

    public function convertirTotal($total)
    {
        $formatter = new NumeroALetras();
        $convertir = $formatter->toInvoice($total, 2, 'SOLES');
        return $convertir;
    }

    public function store(Request $request)
    {
       
        $data = $request->all();
        $rules = [
            'comprobante_id' => 'required',
            'fecha_emision'=> 'required',
            'tipo_nota'=> 'required',
            'empresa'=> 'required',
            'cliente'=> 'required',
            'motivo' => 'required',
            'comprobante_afectado' => 'required'
            
        ];
        $message = [
            'fecha_emision.required' => 'El campo Fecha de Emisión es obligatorio.',
            'tipo_nota.required' => 'El campo Tipo es obligatorio.',
            'empresa.required' => 'El campo Empresa es obligatorio.',
            'cliente.required' => 'El campo Cliente es obligatorio.',
            'motivo.required' => 'El campo Motivo es obligatorio.',
            'comprobante_afectado.required' => 'El campo Comprobante Afectado es obligatorio.',
        ];
        Validator::make($data, $rules, $message)->validate();

        $documento = Documento::findOrFail($request->get('comprobante_id'));

        $nota = new Nota(); 
        $nota->documento_id = $documento->id;  
        $nota->tipDocAfectado = '01';
        $nota->numDocfectado = $documento->serie.'-'.$documento->correlativo;
        $nota->codMotivo = "02";
        $nota->desMotivo =  $request->get('motivo');

        $nota->tipoDoc = '08'; 
        $nota->fechaEmision = Carbon::createFromFormat('d/m/Y', $request->get('fecha_emision'))->format('Y-m-d');

        //EMPRESA
        $nota->ruc_empresa =  $documento->ruc_empresa;
        $nota->empresa =  $documento->empresa;
        $nota->direccion_fiscal_empresa =  $documento->direccion_fiscal_empresa;
        $nota->empresa_id =  $documento->empresa_id; //OBTENER NUMERACION DE LA EMPRESA 
        //CLIENTE       
        $nota->cod_tipo_documento_cliente =  '6';
        $nota->tipo_documento_cliente =  $documento->tipo_documento_cliente;
        $nota->documento_cliente =  $documento->documento_cliente;
        $nota->direccion_cliente =  $documento->direccion_cliente;
        $nota->cliente =  $documento->cliente;

        $nota->sunat = '0';
        $nota->tipo_nota = '1'; //1 -> DEBITO

        $nota->mtoOperGravadas = $request->get('monto_sub_total');
        $nota->mtoIGV = $request->get('monto_total_igv');
        $nota->totalImpuestos = $request->get('monto_total_igv');
        $nota->mtoImpVenta =  $request->get('monto_total');

        $nota->value = self::convertirTotal($request->get('monto_total'));
        $nota->code = '1000';
        $nota->save();

        //Llenado de los articulos
        $productosJSON = $request->get('productos_tabla');
        $productotabla = json_decode($productosJSON[0]);

        foreach ($productotabla as $producto) {
            $lote = LoteProducto::findOrFail($producto->producto_id);
            NotaDetalle::create([
                'nota_id' => $nota->id,
                'codProducto' => $lote->producto->codigo,
                'unidad' => $lote->producto->getMedida(), 
                'descripcion' => $lote->producto->nombre.' - '.$lote->codigo,
                'cantidad' => $producto->cantidad,
        
                'mtoBaseIgv' => ($producto->precio / 1.18) * $producto->cantidad, 
                'porcentajeIgv' => 18,
                'igv' => ($producto->precio - ($producto->precio / 1.18 )) * $producto->cantidad,
                'tipAfeIgv' => 10,
        
                'totalImpuestos' => ($producto->precio - ($producto->precio / 1.18 )) * $producto->cantidad,
                'mtoValorVenta' => ($producto->precio / 1.18) * $producto->cantidad,
                'mtoValorUnitario'=>  $producto->precio / 1.18,
                'mtoPrecioUnitario' => $producto->precio,
            ]);
        }

        //Registro de actividad
        $descripcion = "SE AGREGÓ UNA NOTA DE DEBITO CON LA FECHA: ". Carbon::parse($nota->fechaEmision)->format('d/m/y');
        $gestion = "NOTA DE DEBITO";
        crearRegistro($nota , $descripcion , $gestion);
        
        Session::flash('success','Nota de debito creada.');
        return redirect()->route('ventas.notas')->with('guardar', 'success');

    }

    public function obtenerLeyenda($nota)
    {
        //CREAR LEYENDA DEL COMPROBANTE
        $arrayLeyenda = Array();
        $arrayLeyenda[] = array(  
            "code" => $nota->code,
            "value" => $nota->value
        );
        return $arrayLeyenda;
    }

    public function obtenerProductos($detalles)
    {
       
        $arrayProductos = Array();
        for($i = 0; $i < count($detalles); $i++){

            $arrayProductos[] = array(
                "codProducto" => $detalles[$i]->codProducto,
                "unidad" => $detalles[$i]->unidad,
                "descripcion"=> $detalles[$i]->descripcion,
                "cantidad" => $detalles[$i]->cantidad,

                'mtoBaseIgv' => floatval($detalles[$i]->mtoBaseIgv),
                'porcentajeIgv'=> floatval( $detalles[$i]->porcentajeIgv),
                'igv' => floatval($detalles[$i]->igv),
                'tipAfeIgv' => floatval($detalles[$i]->tipAfeIgv),

                'totalImpuestos' => floatval($detalles[$i]->totalImpuestos),
                'mtoValorVenta' => floatval($detalles[$i]->mtoValorVenta),
                'mtoValorUnitario' => floatval($detalles[$i]->mtoValorUnitario),
                'mtoPrecioUnitario' => floatval($detalles[$i]->mtoPrecioUnitario),

            );
        }

        return $arrayProductos;
    }

    public function show($id)
    {
        $nota = Nota::findOrFail($id);
        $detalles = NotaDetalle::where('nota_id',$id)->get();
        //ARREGLO COMPROBANTE
        $arreglo_nota = array(
            "tipDocAfectado" => $nota->tipDocAfectado,
            "numDocfectado" => $nota->numDocfectado,
            "codMotivo" => $nota->codMotivo,
            "desMotivo" => $nota->desMotivo,
            "tipoDoc" => $nota->tipoDoc,
            "fechaEmision" => self::obtenerFecha($nota->fechaEmision),
            "tipoMoneda" => $nota->tipoMoneda,
            "serie" => $nota->sunat==1 ? $nota->serie : '000',
            "correlativo" => $nota->sunat==1 ? $nota->correlativo : '000',
            "company" => array(  
                "ruc" => $nota->ruc_empresa,
                "razonSocial" => $nota->empresa,
                "address" => array(
                    "direccion" => $nota->direccion_fiscal_empresa,
                )),


            "client" => array(  
                "tipoDoc" =>  $nota->cod_tipo_documento_cliente,
                "numDoc" => $nota->documento_cliente,
                "rznSocial" => $nota->cliente,
                "address" => array(
                    "direccion" => $nota->direccion_cliente,
                )
            ),

            "mtoOperGravadas" =>  floatval($nota->mtoOperGravadas),
            "mtoIGV" => floatval($nota->mtoIGV),
            "totalImpuestos" => floatval($nota->totalImpuestos),
            "mtoImpVenta" => floatval($nota->mtoImpVenta),
            "ublVersion" =>  $nota->ublVersion,
            "details" => self::obtenerProductos($detalles),
            "legends" =>  self::obtenerLeyenda($nota),
        );

        $nota_json= json_encode($arreglo_nota);
        $data = pdfNotaapi($nota_json);
        $name = $nota->id.'.pdf';
        $pathToFile = storage_path('app'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'notas'.DIRECTORY_SEPARATOR.$name);
        if(!file_exists(storage_path('app'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'notas'))) {
            mkdir(storage_path('app'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'notas'));
        }
        file_put_contents($pathToFile, $data);
        return response()->file($pathToFile);
    }

    public function obtenerCorrelativo($nota, $numeracion)
    {
     
        $serie_comprobantes = DB::table('empresa_numeracion_facturaciones')
                            ->join('empresas','empresas.id','=','empresa_numeracion_facturaciones.empresa_id')
                            ->join('cotizacion_documento','cotizacion_documento.empresa_id','=','empresas.id')
                            ->join('nota_electronica','nota_electronica.documento_id','=','cotizacion_documento.id')
                            ->when($nota->tipo_nota, function ($query, $request) {
                                if ($request == '1') {
                                    return $query->where('empresa_numeracion_facturaciones.tipo_comprobante',134);
                                }else{
                                    return $query->where('empresa_numeracion_facturaciones.tipo_comprobante',133);
                                }
                            })
                            ->where('empresa_numeracion_facturaciones.empresa_id',$nota->empresa_id)
                            ->where('nota_electronica.sunat',"1")
                            ->select('nota_electronica.*','empresa_numeracion_facturaciones.*')
                            ->orderBy('nota_electronica.correlativo','DESC')
                            ->get();


        if (count($serie_comprobantes) == 0) {
            //OBTENER EL DOCUMENTO INICIADO 
            $nota->correlativo = $numeracion->numero_iniciar;
            $nota->serie = $numeracion->serie;
            $nota->update();

            //ACTUALIZAR LA NUMERACION (SE REALIZO EL INICIO)
            self::actualizarNumeracion($numeracion);
            return $nota->correlativo;

        }else{
            //NOTA ES NUEVO EN SUNAT 
            if($nota->sunat != '1' ){
                $ultimo_comprobante = $serie_comprobantes->first();
                $nota->correlativo = $ultimo_comprobante->correlativo+1;
                $nota->serie = $numeracion->serie;
                $nota->update();

                //ACTUALIZAR LA NUMERACION (SE REALIZO EL INICIO)
                self::actualizarNumeracion($numeracion);
                return $nota->correlativo;
            }
        }
        
       
    }

    public function actualizarNumeracion($numeracion)
    {   
        $numeracion->emision_iniciada = '1';
        $numeracion->update();
    }

    public function numeracion($nota)
    {
        // $nota = Nota::findOrFail($id);

        if ($nota->tipo_nota == '1') {
            $numeracion = Numeracion::where('empresa_id',$nota->empresa_id)->where('estado','ACTIVO')->where('tipo_comprobante',134)->first();
        }else{
            $numeracion = Numeracion::where('empresa_id',$nota->empresa_id)->where('estado','ACTIVO')->where('tipo_comprobante',133)->first();
        }

        if ($numeracion) {

            $resultado = ($numeracion)->exists();
            $enviar = [
                'existe' => ($resultado == true) ? true : false,
                'numeracion' => $numeracion,
                'correlativo' => self::obtenerCorrelativo($nota,$numeracion)
            ];
            $collection = collect($enviar);
            return  $collection;
        }
    }

    public function sunat($id)
    {
        $nota = Nota::findOrFail($id);
        $detalles = NotaDetalle::where('nota_id',$id)->get();
        //OBTENER CORRELATIVO DE LA NOTA CREDITO / DEBITO
        $existe = self::numeracion($nota);
        if($existe){
            if ($existe->get('existe') == true) {
                if ($nota->sunat != '1') {
                    //ARREGLO COMPROBANTE
                    $arreglo_nota = array(
                        "tipDocAfectado" => $nota->tipDocAfectado,
                        "numDocfectado" => $nota->numDocfectado,
                        "codMotivo" => $nota->codMotivo,
                        "desMotivo" => $nota->desMotivo,
                        "tipoDoc" => $nota->tipoDoc,
                        "fechaEmision" => self::obtenerFecha($nota->fechaEmision),
                        "tipoMoneda" => $nota->tipoMoneda,
                        "serie" => $existe->get('numeracion')->serie,
                        "correlativo" => $nota->correlativo,
                        "company" => array(  
                            "ruc" => $nota->ruc_empresa,
                            "razonSocial" => $nota->empresa,
                            "address" => array(
                                "direccion" => $nota->direccion_fiscal_empresa,
                            )),


                        "client" => array(  
                            "tipoDoc" =>  $nota->cod_tipo_documento_cliente,
                            "numDoc" => $nota->documento_cliente,
                            "rznSocial" => $nota->cliente,
                            "address" => array(
                                "direccion" => $nota->direccion_cliente,
                            )
                        ),

                        "mtoOperGravadas" =>  floatval($nota->mtoOperGravadas),
                        "mtoIGV" => floatval($nota->mtoIGV),
                        "totalImpuestos" => floatval($nota->totalImpuestos),
                        "mtoImpVenta" => floatval($nota->mtoImpVenta),
                        "ublVersion" =>  $nota->ublVersion,
                        "details" => self::obtenerProductos($detalles),
                        "legends" =>  self::obtenerLeyenda($nota),
                    );
                    //OBTENER JSON DEL COMPROBANTE EL CUAL SE ENVIARA A SUNAT
                    $data = enviarNotaapi(json_encode($arreglo_nota));
                    
                    //RESPUESTA DE LA SUNAT EN JSON
                    $json_sunat = json_decode($data);
                    if ($json_sunat->sunatResponse->success == true) {
        
                        $nota->sunat = '1';
        
                        $data_comprobante = pdfNotaapi(json_encode($arreglo_nota));
                        $name = $existe->get('numeracion')->serie."-".$nota->correlativo.'.pdf';
                        
                        $pathToFile = storage_path('app'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'sunat'.DIRECTORY_SEPARATOR.'nota'.DIRECTORY_SEPARATOR.$name);
        
                        if(!file_exists(storage_path('app'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'sunat'.DIRECTORY_SEPARATOR.'nota'))) {
                            mkdir(storage_path('app'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'sunat'.DIRECTORY_SEPARATOR.'nota'));
                        }
        
                        file_put_contents($pathToFile, $data_comprobante);
                        $nota->nombre_comprobante_archivo = $name;
                        $nota->ruta_comprobante_archivo = 'public/sunat/nota/'.$name;
                        $nota->update(); 
        
        
                        //Registro de actividad
                        $descripcion = "SE AGREGÓ LA NOTA ELECTRONICA: ". $existe->get('numeracion')->serie."-".$nota->correlativo;
                        $gestion = "NOTAS ELECTRONICAS";
                        crearRegistro($nota , $descripcion , $gestion);
                        
                        Session::flash('success','Nota enviada a Sunat con exito.');
                        return view('ventas.notas.index',[
                            
                            'id_sunat' => $json_sunat->sunatResponse->cdrResponse->id,
                            'descripcion_sunat' => $json_sunat->sunatResponse->cdrResponse->description,
                            'notas_sunat' => $json_sunat->sunatResponse->cdrResponse->notes,
                            'sunat_exito' => true
        
                        ])->with('sunat_exito', 'success');
        
                    }else{

                        //COMO SUNAT NO LO ADMITE VUELVE A SER 0 
                        $nota->correlativo = null;
                        $nota->serie = null;
                        $nota->sunat = '2';
                        $nota->update(); 
                        
                        if ($json_sunat->sunatResponse->error) {
                            $id_sunat = $json_sunat->sunatResponse->error->code;
                            $descripcion_sunat = $json_sunat->sunatResponse->error->message;
        
                        
                        }else {
                            $id_sunat = $json_sunat->sunatResponse->cdrResponse->id;
                            $descripcion_sunat = $json_sunat->sunatResponse->cdrResponse->description;
                            
                        };
        
        
                        Session::flash('error','Nota electronica sin exito en el envio a sunat.');
                        return view('ventas.notas.index',[
                            'id_sunat' =>  $id_sunat,
                            'descripcion_sunat' =>  $descripcion_sunat,
                            'sunat_error' => true,
        
                        ])->with('sunat_error', 'error');
                    }
                }else{
                    $nota->sunat = '1';
                    $nota->update();
                    Session::flash('error','Nota fue enviado a Sunat.');
                    return redirect()->route('ventas.notas')->with('sunat_existe', 'error');
                }
            }else{
                Session::flash('error','Nota no registrado en la empresa.');
                return redirect()->route('ventas.notas')->with('sunat_existe', 'error');
            }
        }else{
            Session::flash('error','Empresa sin parametros para emitir comprobantes electronicos');
            return redirect()->route('ventas.notas');
        }
    }
}