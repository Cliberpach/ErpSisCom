<?php

namespace App\Http\Controllers\Compras;

use App\Compras\Documento\Documento;
use App\Compras\Documento\Pago\Transferencia;
use App\Compras\Orden;
use App\Compras\Pago;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PagoController extends Controller
{
    public function index($id)
    {
        
        $orden = Orden::findOrFail($id);

        foreach(tipos_moneda() as $moneda){
            if ($moneda->descripcion == $orden->moneda) {
                $tipo_moneda= $moneda->simbolo;
            }
        }

        //MONTO DE LA ORDEN DE COMPRA (ORDEN - DETALLE)
        $montoTotal = calcularMonto($id);
        
        //PAGOS A LA  ORDEN
        $pagos = DB::table('pagos')
        ->select('pagos.*')
        ->where('pagos.orden_id','=',$id)
        ->where('pagos.estado','!=','ANULADO')
        ->get();

        //CALCULAR LA SUMA DE TODOS LOS PAGOS
        $pagos = DB::table('pagos')
        ->join('ordenes','pagos.orden_id','=','ordenes.id')
        ->select('pagos.*','ordenes.moneda as moneda_orden')
        ->where('pagos.orden_id','=',$id)
        ->where('pagos.estado','!=','ANULADO')
        ->get();

        // MONTOS ACUENTA EN LA MONEDA DE LA ORDEN
        $acuenta = 0;
        $soles = 0;
        foreach($pagos as $pago){
            $acuenta = $acuenta + $pago->monto;
            $soles = $soles + $pago->cambio;
        }

        //SALDO EN RESTANTE EN SOLES
        $total_cambio = $orden->total * $orden->tipo_cambio;
        $saldo_restante_soles =  $total_cambio - $soles;

        //CALCULAR SALDO
        $saldo = $montoTotal - $acuenta;

        if ($saldo == 0.0) {
            $orden->estado = "PAGADA";
            $orden->update();
        }else{
            $orden->estado = "PENDIENTE";
            $orden->update();
        }
        
        return view('compras.ordenes.pagos.index',[
            'orden' => $orden,
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
        $pagos = DB::table('pagos')
        ->join('ordenes','pagos.orden_id','=','ordenes.id')
        ->join('bancos', 'pagos.id_banco_proveedor', '=', 'bancos.id')
        ->select('pagos.*','bancos.descripcion as banco', 'ordenes.moneda as moneda_orden')
        ->where('pagos.orden_id','=',$id)
        ->where('pagos.estado','!=','ANULADO')
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
        $orden = Orden::findOrFail($id);
        $fecha_hoy = Carbon::now()->toDateString();
        $monedas =  tipos_moneda();
        $bancos = bancos();
        $bancos_proveedor = collect([]);
        $bancos_empresa = collect([]);
        foreach($orden->proveedor->bancos as $moneda_bancos){
                $bancos_proveedor->push([
                    'id' => $moneda_bancos->id,
                    'descripcion'=> $moneda_bancos->descripcion,
                    'tipo_moneda' => $moneda_bancos->tipo_moneda,
                    'num_cuenta'=> $moneda_bancos->num_cuenta,
                    'cci'=> $moneda_bancos->cci,
                    'estado'=> $moneda_bancos->estado,
                ]);
        }

        foreach($orden->empresa->bancos as $moneda_bancos){
            $bancos_empresa->push([
                'id' => $moneda_bancos->id,
                'descripcion'=> $moneda_bancos->descripcion,
                'tipo_moneda' => $moneda_bancos->tipo_moneda,
                'num_cuenta'=> $moneda_bancos->num_cuenta,
                'cci'=> $moneda_bancos->cci,
                'estado'=> $moneda_bancos->estado,
            ]);
        }

        $pagos = DB::table('pagos')
        ->join('ordenes','pagos.orden_id','=','ordenes.id')
        ->select('pagos.*','ordenes.moneda as moneda_orden')
        ->where('pagos.orden_id','=',$id)
        ->where('pagos.estado','!=','ANULADO')
        ->get();
        
        // TOTAL DE PAGOS EN SU MONEDA DE LA ORDEN
        $acuenta = 0;
        foreach($pagos as $pago){
            $acuenta = $acuenta + $pago->monto;
        }
             
        $monto = calcularMonto($orden->id);
        $montoRestate = $monto - $acuenta;

        return view('compras.ordenes.pagos.create',[
            'orden' => $orden,
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
        $data = $request->all();

        $rules = [
  
            'id_entidad' => 'required',
            'id_entidad_empresa' => 'required',
            'id_orden' => 'required',
            'archivo' => 'required|mimetypes:application/pdf,image/jpeg,image/png,image/jpg|max:40000',
            'fecha_pago' => 'required',
            'monto' => 'required|numeric',
            'cambio' => 'nullable',
            'moneda' => 'required',
            'observacion' => 'nullable',

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

        $pago = new Pago();
        $pago->orden_id = $request->get('id_orden');
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

        if($request->hasFile('archivo')){                
            $file = $request->file('archivo');
            $name = $file->getClientOriginalName();
            $pago->nombre_archivo = $name;
            $pago->ruta_archivo = $request->file('archivo')->store('public/ordenes/pagos');
        }
        $pago->save();


        
       //AGREGAR PAGO TAMBIEN A LA TRANSFERENCIA de DOCUMENTOS PAGO

        $transferencia = Documento::where('orden_compra',$request->get('id_orden'))->where('estado','!=','ANULADO')->first();

        if ($transferencia) {
            
            $pago_transferencia = new Transferencia();
            $pago_transferencia->documento_id = $transferencia->id;
            $pago_transferencia->id_banco_proveedor = $request->get('id_entidad');
            $pago_transferencia->id_banco_empresa = $request->get('id_entidad_empresa');
            
            $pago_transferencia->moneda_empresa = $request->get('moneda_empresa_pago');
            $pago_transferencia->moneda_proveedor = $request->get('moneda_proveedor_pago');

            $pago_transferencia->fecha_pago = Carbon::createFromFormat('d/m/Y', $request->get('fecha_pago'))->format('Y-m-d');
            $pago_transferencia->monto =  $request->get('monto');
            $pago_transferencia->moneda =  $request->get('moneda');

            $pago_transferencia->tipo_cambio =  $request->get('tipo_cambio');
            $pago_transferencia->cambio =  $request->get('cambio');

            $pago_transferencia->observacion =  $request->get('observacion');

            if($request->hasFile('archivo')){                
                $file = $request->file('archivo');
                $name = $file->getClientOriginalName();
                $pago_transferencia->nombre_archivo = $name;
                $pago_transferencia->ruta_archivo = $request->file('archivo')->store('public/documentos/pagos');
            }
            $pago_transferencia->save();

            //Registro de actividad
            $descripcion = "SE AGREGÓ EL PAGO A LA ORDEN DE COMPRA (TRANSFERENCIA) CON EL MONTO: ".  $pago_transferencia->monto;
            $gestion = "PAGO (ORDEN DE COMPRA) - TRANSFERENCIA";
            crearRegistro(  $pago_transferencia, $descripcion , $gestion);
        
        }

        //Registro de actividad
        $descripcion = "SE AGREGÓ EL PAGO A LA ORDEN DE COMPRA CON LA FECHA DE PAGO: ".  $pago->fecha_pago;
        $gestion = "PAGO (ORDEN DE COMPRA)";
        crearRegistro(  $pago, $descripcion , $gestion);

 

        Session::flash('success','Pago creado.');
        return redirect()->route('compras.pago.index',$request->get('id_orden'))->with('guardar', 'success');
        
      

    }

    public function destroy(Request $request)
    {        
        $pago = Pago::findOrFail($request->get('pago'));
        $pago->estado = 'ANULADO';
        $pago->update();

        $transferencia = Documento::where('orden_compra',$pago->orden_id)->where('estado','!=','ANULADO')->first();
        
        if ($transferencia) {

            $transferencias = Transferencia::where('documento_id',$transferencia->id)->get();

            foreach($transferencias as $trans){
                $trans->estado = "ANULADO";
                $trans->update();
            }
            
            $pagos =  Pago::where('orden_id',$pago->orden_id)->where('estado','ACTIVO')->get();

            foreach ($pagos as $pago) {
                Transferencia::create([
                    'documento_id' => $transferencia->id,
                    'id_banco_proveedor' => $pago->id_banco_proveedor,
                    'id_banco_empresa' => $pago->id_banco_empresa,
                    'ruta_archivo' => $pago->ruta_archivo,
                    'nombre_archivo' => $pago->nombre_archivo,
                    'fecha_pago' => $pago->fecha_pago,
                    'monto' => $pago->monto,
                    'moneda' => $pago->moneda,
                    'moneda_empresa' => $pago->moneda_empresa,
                    'moneda_proveedor' => $pago->moneda_proveedor,
                    'tipo_cambio' => $pago->tipo_cambio,
                    'cambio' => $pago->cambio,
                    'observacion' => $pago->observacion,
                    'estado' => $pago->estado,
                ]);
            }

        }
        
        //Registro de actividad
        $descripcion = "SE ELIMINÓ EL PAGO A LA ORDEN DE COMPRA CON LA FECHA DE PAGO: ".  $pago->fecha_pago;
        $gestion = "PAGO (ORDEN DE COMPRA)";
        eliminarRegistro(  $pago, $descripcion , $gestion);

        Session::flash('success','Pago eliminado.');
        return redirect()->route('compras.pago.index', $request->get('amp;orden'))->with('eliminar', 'success');

    }

    public function show(Request $request)
    {                
        $pago = DB::table('pagos')
        ->join('bancos', 'pagos.id_banco_proveedor', '=', 'bancos.id')
        ->join('banco_empresas', 'pagos.id_banco_empresa', '=', 'banco_empresas.id')
        ->select('pagos.*','bancos.*','bancos.id as banco_proveedor_id', 'pagos.id as id_pago', 'banco_empresas.id as banco_empresa_id','banco_empresas.descripcion as descripcion_empresa','banco_empresas.tipo_moneda as moneda_empresa','banco_empresas.num_cuenta as cuenta_empresa','banco_empresas.cci as cci_empresa')
        ->where('pagos.id','=',$request->get('pago'))
        ->where('pagos.estado','=','ACTIVO')
        ->get();
        
        foreach(tipos_moneda() as $moneda){
            if ($moneda->descripcion == $pago[0]->moneda) {
                $tipo_moneda= $moneda->simbolo;
            }
        }
        $orden = Orden::findOrFail($request->get('orden') );
        // dd($orden);
        return view('compras.ordenes.pagos.show',[
            'pago' => $pago,
            'orden' => $orden,
            'tipo_moneda' => $tipo_moneda
        ]);

    }
}
