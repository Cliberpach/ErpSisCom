<?php

namespace App\Http\Controllers\Ventas\Electronico;

use App\Events\DocumentoNumeracion;
use App\Http\Controllers\Controller;
use App\Ventas\Documento\Detalle;
use App\Ventas\Documento\Documento;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Luecano\NumeroALetras\NumeroALetras;
use Yajra\DataTables\Facades\DataTables;

class ComprobanteController extends Controller
{
    public function index()
    {
        return view('ventas.comprobantes.index');
    }

    public function getVouchers(){
        
        $documentos = Documento::where('sunat',"1")->orderBy('id','DESC')->get();

        $coleccion = collect([]);
        foreach($documentos as $documento){

            $coleccion->push([
                'id' => $documento->id,
                'numero' => $documento->serie.'-'.$documento->correlativo,
                'tipo_venta' => $documento->descripcionTipo(),
                'cliente' => $documento->tipo_documento_cliente.': '.$documento->documento_cliente.' - '.$documento->cliente,
                'empresa' => $documento->empresa,
                'fecha_documento' =>  Carbon::parse($documento->fecha_documento)->format( 'd/m/Y'),
                'total' => 'S/. '.number_format($documento->total, 2, '.', ''),
                'ruta_comprobante_archivo' => $documento->ruta_comprobante_archivo,
                'nombre_comprobante_archivo' => $documento->nombre_comprobante_archivo,
                'sunat' => $documento->sunat,
            ]);
        }
        return DataTables::of($coleccion)->toJson();
    }


    public function obtenerLeyenda($documento)
    {
        $formatter = new NumeroALetras();
        $convertir = $formatter->toInvoice($documento->total, 2, 'SOLES');

        //CREAR LEYENDA DEL COMPROBANTE
        $arrayLeyenda = Array();
        $arrayLeyenda[] = array(  
            "code" => "1000",
            "value" => $convertir
        );
        return $arrayLeyenda;
    }

    public function obtenerProductos($id)
    {
        $detalles = Detalle::where('documento_id',$id)->get();
        $arrayProductos = Array();
        for($i = 0; $i < count($detalles); $i++){

            $arrayProductos[] = array(
                "codProducto" => $detalles[$i]->codigo_producto,
                "unidad" => $detalles[$i]->unidad,
                "descripcion"=> $detalles[$i]->nombre_producto.' - '.$detalles[$i]->codigo_lote,
                "cantidad" => (float)$detalles[$i]->cantidad,
                "mtoValorUnitario" => (float)($detalles[$i]->precio_nuevo / 1.18),
                "mtoValorVenta" => (float)($detalles[$i]->valor_venta / 1.18),
                "mtoBaseIgv" => (float)($detalles[$i]->valor_venta / 1.18), 
                "porcentajeIgv" => 18,
                "igv" => (float)($detalles[$i]->valor_venta - ($detalles[$i]->valor_venta / 1.18)),
                "tipAfeIgv" => 10,
                "totalImpuestos" =>  (float)($detalles[$i]->valor_venta - ($detalles[$i]->valor_venta / 1.18)),
                "mtoPrecioUnitario" => (float)$detalles[$i]->precio_nuevo

            );
        }

        return $arrayProductos;
    }

    public function obtenerFecha($documento)
    {
        $date = strtotime($documento->fecha_documento);
        $fecha_emision = date('Y-m-d', $date); 
        $hora_emision = date('H:i:s', $date); 
        $fecha = $fecha_emision.'T'.$hora_emision.'-05:00';

        return $fecha;
    }


    public function sunat($id)
    {
       
        $documento = Documento::findOrFail($id);
        //OBTENER CORRELATIVO DEL COMPROBANTE ELECTRONICO
        $existe = event(new DocumentoNumeracion($documento));
        if($existe[0]){
            if ($existe[0]->get('existe') == true) {
                if ($documento->sunat != '1') {
                    //ARREGLO COMPROBANTE
                    $arreglo_comprobante = array(
                        "tipoOperacion" => $documento->tipoOperacion(),
                        "tipoDoc"=> $documento->tipoDocumento(),
                        "serie" => $existe[0]->get('numeracion')->serie,
                        "correlativo" => $documento->correlativo,
                        "fechaEmision" => self::obtenerFecha($documento),
                        "observacion" => $documento->observacion,
                        "tipoMoneda" => $documento->simboloMoneda(),
                        "client" => array(
                            "tipoDoc" => $documento->tipoDocumentoCliente(),
                            "numDoc" => $documento->documento_cliente,
                            "rznSocial" => $documento->cliente,
                            "address" => array(
                                "direccion" => $documento->direccion_cliente,
                            )),
                        "company" => array(
                            "ruc" =>  $documento->ruc_empresa,
                            "razonSocial" => $documento->empresa,
                            "address" => array(
                                "direccion" => $documento->direccion_fiscal_empresa,
                            )),
                        "mtoOperGravadas" => (float)$documento->sub_total,
                        "mtoOperExoneradas" => 0,
                        "mtoIGV" => (float)$documento->total_igv,
                        
                        "valorVenta" => (float)$documento->sub_total,
                        "totalImpuestos" => (float)$documento->total_igv,
                        "subTotal" => (float)$documento->total,
                        "mtoImpVenta" => (float)$documento->total,
                        "ublVersion" => "2.1",
                        "details" => self::obtenerProductos($documento->id),
                        "legends" =>  self::obtenerLeyenda($documento),
                    );

                    // return $arreglo_comprobante;
                    //OBTENER JSON DEL COMPROBANTE EL CUAL SE ENVIARA A SUNAT
                    $data = enviarComprobanteapi(json_encode($arreglo_comprobante), $documento->empresa_id);

                    //RESPUESTA DE LA SUNAT EN JSON
                    $json_sunat = json_decode($data);
                    if ($json_sunat->sunatResponse->success == true) {
        
                        $documento->sunat = '1';
        
                        $data_comprobante = generarComprobanteapi(json_encode($arreglo_comprobante), $documento->empresa_id);
                        $name = $existe[0]->get('numeracion')->serie."-".$documento->correlativo.'.pdf';
                        
                        $pathToFile = storage_path('app'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'sunat'.DIRECTORY_SEPARATOR.$name);
        
                        if(!file_exists(storage_path('app'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'sunat'))) {
                            mkdir(storage_path('app'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'sunat'));
                        }
        
                        file_put_contents($pathToFile, $data_comprobante);
                        $documento->nombre_comprobante_archivo = $name;
                        $documento->ruta_comprobante_archivo = 'public/sunat/'.$name;
                        $documento->update(); 
        
        
                        //Registro de actividad
                        $descripcion = "SE AGREGÓ EL COMPROBANTE ELECTRONICO: ". $existe[0]->get('numeracion')->serie."-".$documento->correlativo;
                        $gestion = "COMPROBANTES ELECTRONICOS";
                        crearRegistro($documento , $descripcion , $gestion);
                        
                        Session::flash('success','Documento de Venta enviada a Sunat con exito.');
                        return view('ventas.documentos.index',[
                            
                            'id_sunat' => $json_sunat->sunatResponse->cdrResponse->id,
                            'descripcion_sunat' => $json_sunat->sunatResponse->cdrResponse->description,
                            'notas_sunat' => $json_sunat->sunatResponse->cdrResponse->notes,
                            'sunat_exito' => true
        
                        ])->with('sunat_exito', 'success');
        
                    }else{

                        //COMO SUNAT NO LO ADMITE VUELVE A SER 0 
                        $documento->correlativo = null;
                        $documento->serie = null;
                        $documento->sunat = '2';
                        $documento->update(); 
                        
                        if ($json_sunat->sunatResponse->error) {
                            $id_sunat = $json_sunat->sunatResponse->error->code;
                            $descripcion_sunat = $json_sunat->sunatResponse->error->message;
        
                        
                        }else {
                            $id_sunat = $json_sunat->sunatResponse->cdrResponse->id;
                            $descripcion_sunat = $json_sunat->sunatResponse->cdrResponse->description;
                            
                        };
        
        
                        Session::flash('error','Documento de Venta sin exito en el envio a sunat.');
                        return view('ventas.documentos.index',[
                            'id_sunat' =>  $id_sunat,
                            'descripcion_sunat' =>  $descripcion_sunat,
                            'sunat_error' => true,
        
                        ])->with('sunat_error', 'error');
                    }
                }else{
                    $documento->sunat = '1';
                    $documento->update();
                    Session::flash('error','Documento de venta fue enviado a Sunat.');
                    return redirect()->route('ventas.documento.index')->with('sunat_existe', 'error');
                }
            }else{
                Session::flash('error','Tipo de Comprobante no registrado en la empresa.');
                return redirect()->route('ventas.documento.index')->with('sunat_existe', 'error');
            }
        }else{
            Session::flash('error','Empresa sin parametros para emitir comprobantes electronicos');
            return redirect()->route('ventas.documento.index');
        }
        
    }
}
