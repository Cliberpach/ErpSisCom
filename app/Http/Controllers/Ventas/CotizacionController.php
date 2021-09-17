<?php

namespace App\Http\Controllers\Ventas;

use App\Almacenes\LoteProducto;
use App\Http\Controllers\Controller;
use App\Mantenimiento\Empresa\Empresa;
use App\Ventas\Cliente;
use App\Ventas\Cotizacion;
use App\Ventas\CotizacionDetalle;
use App\Ventas\Documento\Documento;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Mail;

class CotizacionController extends Controller
{
    public function index()
    {
        return view('ventas.cotizaciones.index');
    }

    public function getTable()
    {
        $cotizaciones = Cotizacion::where('estado', '<>', 'ANULADO')->orderBy('id', 'desc')->get();
        $coleccion = collect([]);
        foreach($cotizaciones as $cotizacion) {
            $coleccion->push([
                'id' => $cotizacion->id,
                'empresa' => $cotizacion->empresa->razon_social,
                'cliente' => $cotizacion->cliente->nombre,
                'fecha_documento' => Carbon::parse($cotizacion->fecha_documento)->format( 'd/m/Y'),
                'total' => $cotizacion->total,
                'estado' => $cotizacion->estado
            ]);
        }
        return DataTables::of($coleccion)->toJson();
    }

    public function create()
    {
        $empresas = Empresa::where('estado', 'ACTIVO')->get();
        $clientes = Cliente::where('estado', 'ACTIVO')->get();
        $fecha_hoy = Carbon::now()->toDateString();
        $lotes = LoteProducto::where('estado', '1')->distinct()->get(['producto_id']);

        return view('ventas.cotizaciones.create', compact('empresas', 'clientes', 'fecha_hoy', 'lotes'));
    }

    public function store(Request $request)
    {
       // return $request;
        $data = $request->all();
        $rules = [
            'empresa' => 'required',
            'cliente' => 'required',
            'fecha_documento' => 'required|date_format:d/m/Y',
            'fecha_atencion_campo' => 'nullable|date_format:d/m/Y',
            'igv' => 'required_if:igv_check,==,on|numeric|digits_between:1,3',
        ];

        $message = [
            'empresa.required' => 'El campo Empresa es obligatorio',
            'cliente.required' => 'El campo Cliente es obligatorio',
            'moneda' => 'El campo Moneda es obligatorio',
            'fecha_documento.required' => 'El campo Fecha de Documento es obligatorio',
            'fecha_documento.date_format:d/m/Y' => 'El formato de la Fecha de Documento es incorrecto',
            'fecha_atencion_campo.date_format:d/m/Y' => 'El formato de la Fecha de Atención es incorrecto',
            'igv.required_if' => 'El campo Igv es obligatorio.',
            'igv.digits' => 'El campo Igv puede contener hasta 3 dígitos.',
            'igv.numeric' => 'El campo Igv debe se numérico.',
        ];

        Validator::make($data, $rules, $message)->validate();

        $cotizacion = new Cotizacion();
        $cotizacion->empresa_id = $request->get('empresa');
        $cotizacion->cliente_id = $request->get('cliente');
        $cotizacion->vendedor_id = $request->get('vendedor');
        $cotizacion->moneda = 4;
        $cotizacion->fecha_documento = Carbon::createFromFormat('d/m/Y', $request->get('fecha_documento'))->format('Y-m-d');
        $cotizacion->fecha_atencion = Carbon::createFromFormat('d/m/Y', $request->get('fecha_atencion_campo'))->format('Y-m-d');

        $cotizacion->sub_total = 0;
        $cotizacion->total_igv =0;
        $cotizacion->total = (float) $request->get('monto_total');

        $cotizacion->user_id = Auth::id();
        $cotizacion->igv = $request->get('igv');
        if ($request->get('igv_check') == "on") {
            $cotizacion->igv_check = "1";
        };
        $cotizacion->save();

        //Llenado de los Productos
        $productosJSON = $request->get('productos_tabla');
        $productotabla = json_decode($productosJSON[0]);

        foreach ($productotabla as $producto) {
            CotizacionDetalle::create([
                'cotizacion_id' => $cotizacion->id,
                'producto_id' => $producto->producto_id,
                'descuento'=> $producto->descuento,
                'dinero'=> $producto->dinero,
                'precio_nuevo' => $producto->precionuevo,
                'cantidad' => $producto->cantidad,
                'precio' => $producto->precio,
                'importe' => $producto->total,
            ]);
        }

        //Registro de actividad
        $descripcion = "SE AGREGÓ LA COTIZACION CON LA FECHA: ". Carbon::parse($cotizacion->fecha_documento)->format('d/m/y');
        $gestion = "COTIZACION";
        crearRegistro($cotizacion, $descripcion , $gestion);

        Session::flash('success','Cotización creada.');
        return redirect()->route('ventas.cotizacion.index')->with('guardar', 'success');
    }

    public function edit($id)
    {
        $cotizacion = Cotizacion::findOrFail($id);
        $empresas = Empresa::where('estado', 'ACTIVO')->get();
        $clientes = Cliente::where('estado', 'ACTIVO')->get();
        $fecha_hoy = Carbon::now()->toDateString();
        $lotes = LoteProducto::where('estado', '1')->distinct()->get(['producto_id']);

        $detalles = CotizacionDetalle::where('cotizacion_id',$id)->where('estado', 'ACTIVO')->get();

        return view('ventas.cotizaciones.edit', [
            'cotizacion' => $cotizacion,
            'empresas' => $empresas,
            'clientes' => $clientes,
            'fecha_hoy' => $fecha_hoy,
            'lotes' => $lotes,
            'detalles' => $detalles 
        ]);
    }

    public function update(Request $request,$id)
    {
        $data = $request->all();

        $rules = [
            'empresa' => 'required',
            'cliente' => 'required',
            'fecha_documento' => 'required|date_format:d/m/Y',
            'fecha_atencion_campo' => 'nullable|date_format:d/m/Y',
            'igv' => 'required_if:igv_check,==,on|numeric|digits_between:1,3',
        ];

        $message = [
            'empresa.required' => 'El campo Empresa es obligatorio',
            'cliente.required' => 'El campo Cliente es obligatorio',
            'moneda' => 'El campo Moneda es obligatorio',
            'fecha_documento.required' => 'El campo Fecha de Documento es obligatorio',
            'fecha_documento.date_format:d/m/Y' => 'El formato de la Fecha de Documento es incorrecto',
            'fecha_atencion_campo.date_format:d/m/Y' => 'El formato de la Fecha de Atención es incorrecto',
            'igv.required_if' => 'El campo Igv es obligatorio.',
            'igv.digits' => 'El campo Igv puede contener hasta 3 dígitos.',
            'igv.numeric' => 'El campo Igv debe se numérico.',
        ];

        Validator::make($data, $rules, $message)->validate();


            $cotizacion =  Cotizacion::findOrFail($id);
            $cotizacion->empresa_id = $request->get('empresa');
            $cotizacion->cliente_id = $request->get('cliente');
            $cotizacion->vendedor_id = $request->get('vendedor');
            $cotizacion->fecha_documento = Carbon::createFromFormat('d/m/Y', $request->get('fecha_documento'))->format('Y-m-d');
            $cotizacion->fecha_atencion = Carbon::createFromFormat('d/m/Y', $request->get('fecha_atencion'))->format('Y-m-d');

            // $cotizacion->sub_total = (float) $request->get('monto_sub_total');
            // $cotizacion->total_igv = (float) $request->get('monto_total_igv');
            $cotizacion->sub_total =0;
            $cotizacion->total_igv =0;
            $cotizacion->total = (float) $request->get('monto_total');

            $cotizacion->user_id = Auth::id();
            $cotizacion->igv = $request->get('igv');

            if ($request->get('igv_check') == "on") {
                $cotizacion->igv_check = "1";
            }else{
                $cotizacion->igv_check = '';
            }

            $cotizacion->update();

            $productosJSON = $request->get('productos_tabla');
            $productotabla = json_decode($productosJSON[0]);
            if ($productotabla) {
                CotizacionDetalle::where('cotizacion_id', $id)->delete();

                foreach ($productotabla as $cotizacion_detalle) {
                    CotizacionDetalle::create([
                        'cotizacion_id'=> $cotizacion->id,
                        'producto_id' => $cotizacion_detalle->producto_id,
                        'cantidad' => $cotizacion_detalle->cantidad,
                        'descuento'=>$cotizacion_detalle->descuento==""? 0 :$cotizacion_detalle->descuento,
                        'dinero'=>$cotizacion_detalle->dinero,
                        'precio_nuevo' =>$cotizacion_detalle->precionuevo,
                        'precio' => $cotizacion_detalle->precio,
                        'importe' => $cotizacion_detalle->total,
                    ]);
                }




            }

        //Registro de actividad
        $descripcion = "SE MODIFICÓ LA COTIZACION CON LA FECHA: ". Carbon::parse($cotizacion->fecha_documento)->format('d/m/y');;
        $gestion = "COTIZACION";
        modificarRegistro($cotizacion, $descripcion , $gestion);

        //ELIMINAR DOCUMENTO DE ORDEN DE COMPRA SI EXISTE
        $documento = Documento::where('cotizacion_venta',$id)->where('estado','!=','ANULADO')->first();
        if ($documento) {
            $documento->estado = 'ANULADO';
            $documento->update();

            Session::flash('success','Cotización modificada y documento eliminado.');
            return redirect()->route('ventas.cotizacion.index')->with('modificar', 'success');

        }else{
            Session::flash('success','Cotización modificada.');
            return redirect()->route('ventas.cotizacion.index')->with('modificar', 'success');

        }



    }

    public function show($id)
    {
        $cotizacion = Cotizacion::findOrFail($id);
        $nombre_completo = $cotizacion->user->empleado->persona->apellido_paterno.' '.$cotizacion->user->empleado->persona->apellido_materno.' '.$cotizacion->user->empleado->persona->nombres;
        $presentaciones = presentaciones();
        $detalles = CotizacionDetalle::where('cotizacion_id',$id)->where('estado','ACTIVO')->get();



        return view('ventas.cotizaciones.show', [
            'cotizacion' => $cotizacion,
            'detalles' => $detalles,
            'presentaciones' => $presentaciones,
            'nombre_completo' => $nombre_completo
        ]);
    }

    public function destroy($id)
    {

        $cotizacion = Cotizacion::findOrFail($id);
        $cotizacion->estado = "ANULADO";
        $cotizacion->update();

        $cotizacion_detalle = CotizacionDetalle::where('cotizacion_id',$id)->get();
        foreach ($cotizacion_detalle as $detalle) {
            $detalle->estado = "ANULADO";
            $detalle->update();

        }

        //Registro de actividad
        $descripcion = "SE ELIMINÓ LA COTIZACION CON LA FECHA: ". Carbon::parse($cotizacion->fecha_documento)->format('d/m/y');
        $gestion = "COTIZACION";
        eliminarRegistro($cotizacion, $descripcion , $gestion);

        Session::flash('success','Cotización eliminada.');
        return redirect()->route('ventas.cotizacion.index')->with('eliminar', 'success');
    }

    public function email($id)
    {

        $cotizacion = Cotizacion::findOrFail($id);
        $nombre_completo = $cotizacion->user->empleado->persona->apellido_paterno.' '.$cotizacion->user->empleado->persona->apellido_materno.' '.$cotizacion->user->empleado->persona->nombres;
        $igv = '';
        $tipo_moneda = '';
        $detalles = $cotizacion->detalles->where('estado', 'ACTIVO');


        // $presentaciones = presentaciones();
        $paper_size = array(0,0,360,360);
        $pdf = PDF::loadview('ventas.cotizaciones.reportes.detalle',[
            'cotizacion' => $cotizacion,
            'nombre_completo' => $nombre_completo,
            'detalles' => $detalles,
            ])->setPaper('a4')->setWarnings(false);

        Mail::send('email.cotizacion',compact("cotizacion"), function ($mail) use ($pdf,$cotizacion) {
            $mail->to($cotizacion->cliente->correo_electronico);
            $mail->subject('COTIZACION OC-0'.$cotizacion->id);
            $mail->attachdata($pdf->output(), 'COTIZACION CO-0'.$cotizacion->id.'.pdf');
        });

        Session::flash('success','Cotización enviado al correo '.$cotizacion->cliente->correo_electronico);
        return redirect()->route('ventas.cotizacion.show', $cotizacion->id)->with('enviar', 'success');
    }

    public function report($id)
    {
        $cotizacion = Cotizacion::findOrFail($id);
        $nombre_completo = $cotizacion->user->empleado->persona->apellido_paterno.' '.$cotizacion->user->empleado->persona->apellido_materno.' '.$cotizacion->user->empleado->persona->nombres;

        $igv = '';
        $tipo_moneda = '';
        $detalles = $cotizacion->detalles->where('estado', 'ACTIVO');

        $paper_size = array(0,0,360,360);
        $pdf = PDF::loadview('ventas.cotizaciones.reportes.detalle',[
            'cotizacion' => $cotizacion,
            'nombre_completo' => $nombre_completo,
            'detalles' => $detalles,
            ])->setPaper('a4')->setWarnings(false);
        return $pdf->stream();

    }

    public function document($id){

        $documento = Documento::where('cotizacion_venta',$id)->where('estado','!=','ANULADO')->first();
        if ($documento) {

            return view('ventas.cotizaciones.index',[
                'id' => $id
            ]);
        }else{
            //REDIRECCIONAR AL DOCUMENTO DE VENTA
            return redirect()->route('ventas.documento.create',['cotizacion'=>$id]);
        }

    }


    public function newDocument($id){
        $documento_old =  Documento::where('cotizacion_venta',$id)->where('estado','!=','ANULADO')->first();
        foreach ($documento_old->detalles as $detalle) {
            $lote = LoteProducto::find($detalle->lote_id);
            $cantidad = $lote->cantidad + $detalle->cantidad;
            $lote->cantidad = $cantidad;
            $lote->cantidad_logica = $cantidad;
            $lote->update();
            //ANULAMOS EL DETALLE
            $detalle->estado = "ANULADO";
            $detalle->update();
        }
        //ANULADO ANTERIO DOCUMENTO
        $documento = Documento::findOrFail($documento_old->id);
        $documento->estado = 'ANULADO';
        $documento->update();
        //REDIRECCIONAR AL DOCUMENTO DE VENTA
        return redirect()->route('ventas.documento.create',['cotizacion'=>$id]);

    }
}
