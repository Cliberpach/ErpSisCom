<?php

namespace App\Http\Controllers\Compras\Documentos;

use App\Compras\Documento\Documento;
use App\Compras\Documento\Pago\Transferencia;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class TransferenciaController extends Controller
{
    public function index($id)
    {
        actualizarStockLotes();
        $documento = Documento::findOrFail($id);
        foreach(tipos_moneda() as $moneda){
            if ($moneda->descripcion == $documento->moneda) {
                $tipo_moneda= $moneda->simbolo;
            }
        }

        //MONTO DEL DOCUMENTO DE COMPRA (DOCUMENTO - DETALLE)
        $montoTotal = calcularMontoDocumento($documento->id);


        //CALCULAR LA SUMA DE TODOS LOS PAGOS
        $pagos = DB::table('compra_documento_transferencia')
        ->join('compra_documentos','compra_documento_transferencia.documento_id','=','compra_documentos.id')
        ->select('compra_documento_transferencia.*','compra_documentos.moneda as moneda_orden')
        ->where('compra_documento_transferencia.documento_id','=',$id)
        ->where('compra_documento_transferencia.estado','!=','ANULADO')
        ->get();

        // MONTOS ACUENTA EN LA MONEDA DE LA ORDEN
        $acuenta = 0;
        $soles = 0;
        foreach($pagos as $pago){
            $acuenta = $acuenta + $pago->monto;
            $soles = $soles + $pago->cambio;
        }


        //SALDO EN RESTANTE EN SOLES
        $total_cambio = $documento->total * $documento->tipo_cambio;
        $saldo_restante_soles =  $total_cambio - $soles;

        // //CALCULAR SALDO
        $saldo = $montoTotal - $acuenta;

        
        if ($saldo == 0.0) {
            $documento->estado = "PAGADA";
            $documento->update();
        }else{
            $documento->estado = "PENDIENTE";
            $documento->update();
        }
        
        // dd($total_cambio);
        return view('compras.documentos.transferencia.index',[
            'documento' => $documento,
            'moneda' => $tipo_moneda,
            'monto' => $montoTotal,
            'moneda' => $tipo_moneda,
            'saldo' => number_format($saldo, 2, '.', ''),
            'acuenta' =>  number_format($acuenta, 2, '.', ''),
            'total_soles' => number_format($total_cambio, 2, '.', ''),
            'saldo_soles' => number_format($saldo_restante_soles, 2, '.', ''),
            'acuenta_soles' => number_format($soles, 2, '.', '')
        ]);
    }

    public function getPay($id)
    {
        $pagos = DB::table('compra_documento_transferencia')
        ->join('compra_documentos','compra_documento_transferencia.documento_id','=','compra_documentos.id')
        ->join('bancos','compra_documento_transferencia.id_banco_proveedor','=','bancos.id')
        ->select('compra_documento_transferencia.*','compra_documentos.moneda as moneda_orden','bancos.descripcion as banco')
        ->where('compra_documento_transferencia.documento_id','=',$id)
        ->where('compra_documento_transferencia.estado','!=','ANULADO')
        ->get();

    

        $coleccion = collect([]);

            foreach($pagos as $pago){

                $simbolo = simbolo_monedas($pago->moneda_orden);
                $cambio = 0 ;
                $tipo_cambio = '';
                if ($pago->moneda_orden == "SOLES") {
                    $cambio = $pago->monto;
                    $tipo_cambio = '-';
                }else{
                    $cambio = $pago->cambio;
                    $tipo_cambio = $pago->tipo_cambio;
                }


                if ($pago->estado == "ACTIVO") {
                    $coleccion->push([
                        'id' => $pago->id,
                        'fecha_pago' => Carbon::parse($pago->fecha_pago)->format( 'd/m/Y'),
                        'entidad'=> $pago->banco,
                        'cuenta_proveedor' => $pago->moneda_proveedor,
                        'cuenta_empresa' => $pago->moneda_empresa,
                        'monto' => $simbolo.' '.number_format($pago->monto,2,'.',''),
                        'tipo_cambio' => $tipo_cambio,
                        'monto_soles' => 'S/. '.number_format($cambio,2,'.',''),
                        ]);
                }
    

            }
            
        
        return DataTables::of($coleccion)->toJson();   
    }
    public function create($id)
    {
        // dd($id);
        $documento = Documento::findOrFail($id);
        $fecha_hoy = Carbon::now()->toDateString();
        $monedas =  tipos_moneda();
        $bancos = bancos();
        $bancos_proveedor = collect([]);
        $bancos_empresa = collect([]);
        foreach($documento->proveedor->bancos as $moneda_bancos){
                $bancos_proveedor->push([
                    'id' => $moneda_bancos->id,
                    'descripcion'=> $moneda_bancos->descripcion,
                    'tipo_moneda' => $moneda_bancos->tipo_moneda,
                    'num_cuenta'=> $moneda_bancos->num_cuenta,
                    'cci'=> $moneda_bancos->cci,
                    'estado'=> $moneda_bancos->estado,
                ]);
        }

        foreach($documento->empresa->bancos as $moneda_bancos){
            $bancos_empresa->push([
                'id' => $moneda_bancos->id,
                'descripcion'=> $moneda_bancos->descripcion,
                'tipo_moneda' => $moneda_bancos->tipo_moneda,
                'num_cuenta'=> $moneda_bancos->num_cuenta,
                'cci'=> $moneda_bancos->cci,
                'estado'=> $moneda_bancos->estado,
            ]);
        }

        $pagos = DB::table('compra_documento_transferencia')
        ->join('compra_documentos','compra_documento_transferencia.documento_id','=','compra_documentos.id')
        ->select('compra_documento_transferencia.*','compra_documentos.moneda as moneda_orden')
        ->where('compra_documento_transferencia.documento_id','=',$id)
        ->where('compra_documento_transferencia.estado','!=','ANULADO')
        ->get();
        
        // TOTAL DE PAGOS EN SU MONEDA DE LA ORDEN
        $acuenta = 0;
        foreach($pagos as $pago){
            $acuenta = $acuenta + $pago->monto;
        }
           
        $monto = calcularMontoDocumento($documento->id);
        $montoRestate = $monto - $acuenta;
        
        return view('compras.documentos.transferencia.create',[
            'documento' => $documento,
            'bancos' => $bancos,
            'fecha_hoy' => $fecha_hoy,
            'monedas' => $monedas,
            'bancos_proveedor' => $bancos_proveedor,
            'bancos_empresa' => $bancos_empresa,
            'monto' =>  number_format($montoRestate, 2, '.', '')
        ]);
    }

    public function store(Request $request)
    {
    //    dd($request);
        $data = $request->all();

        $rules = [
  
            'id_entidad' => 'required',
            'id_entidad_empresa' => 'required',
            'id_documento' => 'required',
            'archivo' => 'required|mimetypes:application/pdf,image/jpeg,image/png,image/jpg|max:40000',
            'fecha_pago' => 'required',
            'monto' => 'required|numeric',
            'moneda' => 'required',
            'observacion' => 'nullable',
            'cambio' => 'nullable',

        ];
        
        $message = [
            'id_entidad.required' => 'Seleccionar una entidad bancaria.',
            'archivo.mimetypes' => 'El campo Archivo no contiene el formato correcto.',
            'archivo.required' => 'El campo Archivo es obligatorio.',
            'archivo.max' => 'El tamaño máximo del Archivo para cargar es de 40 MB.',

            'fecha_pago.required'=> 'El campo Fecha de Pago es obligatorio.',

            'monto.numeric'=> 'El campo Monto debe se numérico.',
            'monto.required'=> 'El campo Monto es obligatorio.',
            
            'moneda.required'=> 'El campo Moneda es obligatorio.',

            'tipo_cambio.required' => 'El campo Tipo de Cambio es obligatorio.',
            'tipo_cambio.numeric' => 'El campo Tipo de Cambio debe ser numérico.',

            'cambio.required' => 'El campo Cambio es obligatorio.',
            'cambio.numeric' => 'El campo Cambio debe ser numérico.',
            

        ];

        Validator::make($data, $rules, $message)->validate();

        $pago = new Transferencia();
        $pago->documento_id = $request->get('id_documento');
        $pago->id_banco_proveedor = $request->get('id_entidad');
        $pago->id_banco_empresa = $request->get('id_entidad_empresa');
        
        $pago->moneda_empresa = $request->get('moneda_empresa_pago');
        $pago->moneda_proveedor = $request->get('moneda_proveedor_pago');

        $pago->fecha_pago = Carbon::createFromFormat('d/m/Y', $request->get('fecha_pago'))->format('Y-m-d');
        $pago->monto =  $request->get('monto');
        $pago->moneda =  $request->get('moneda');

        $pago->tipo_cambio =  $request->get('tipo_cambio');
        $pago->cambio =  $request->get('cambio');

        $pago->observacion =  $request->get('observacion');

        $documento = Documento::findOrFail($request->get('id_documento'));
        $documento->tipo_pago =  "1";
        $documento->update();

        if($request->hasFile('archivo')){                
            $file = $request->file('archivo');
            $name = $file->getClientOriginalName();
            $pago->nombre_archivo = $name;
            $pago->ruta_archivo = $request->file('archivo')->store('public/documentos/pagos');
        }
        $pago->save();

        //Registro de actividad
        $descripcion = "SE AGREGÓ EL PAGO A LA ORDEN DE COMPRA CON LA FECHA DE PAGO: ".  $pago->fecha_pago;
        $gestion = "PAGO (DOCUMENTO DE COMPRA)";
        crearRegistro(  $pago, $descripcion , $gestion);

        Session::flash('success','Pago creado.');
        return redirect()->route('compras.documentos.transferencia.pago.index',$request->get('id_documento'))->with('guardar', 'success');

    }


    public function destroy(Request $request)
    {        
        $pago = Transferencia::findOrFail($request->get('pago'));
        $pago->estado = 'ANULADO';
        $pago->update();

        //Registro de actividad
        $descripcion = "SE ELIMINÓ EL PAGO AL DOCUMENTO DE COMPRA CON LA FECHA DE PAGO: ".  $pago->fecha_pago;
        $gestion = "PAGO (DOCUMENTO DE COMPRA)";
        eliminarRegistro(  $pago, $descripcion , $gestion);

        Session::flash('success','Pago eliminado.');
        return redirect()->route('compras.documentos.transferencia.pago.index', $request->get('amp;documento'))->with('eliminar', 'success');

    }

    public function show(Request $request)
    {                
        $pago = DB::table('compra_documento_transferencia')
        ->join('bancos','compra_documento_transferencia.id_banco_proveedor','=','bancos.id')
        ->join('banco_empresas','compra_documento_transferencia.id_banco_empresa','=','banco_empresas.id')
        ->select('compra_documento_transferencia.*','bancos.*','bancos.id as banco_proveedor_id', 'compra_documento_transferencia.id as id_pago', 'banco_empresas.id as banco_empresa_id','banco_empresas.descripcion as descripcion_empresa','banco_empresas.tipo_moneda as moneda_empresa','banco_empresas.num_cuenta as cuenta_empresa','banco_empresas.cci as cci_empresa')
        ->where('compra_documento_transferencia.id','=',$request->get('pago'))
        ->where('compra_documento_transferencia.estado','=','ACTIVO')
        ->get();
        
        foreach(tipos_moneda() as $moneda){
            if ($moneda->descripcion == $pago[0]->moneda) {
                $tipo_moneda= $moneda->simbolo;
            }
        }
        $documento = Documento::findOrFail($request->get('documento') );
        return view('compras.documentos.transferencia.show',[
            'pago' => $pago,
            'documento' => $documento,
            'tipo_moneda' => $tipo_moneda
        ]);

    }

}
