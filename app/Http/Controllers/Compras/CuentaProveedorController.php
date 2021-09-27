<?php

namespace App\Http\Controllers\Compras;

use App\Compras\CuentaProveedor;
use App\Compras\DetalleCuentaProveedor;
use App\Compras\Proveedor;
use App\Http\Controllers\Controller;
use App\Mantenimiento\Empresa\Empresa;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class CuentaProveedorController extends Controller
{
    public function index() {
        return view('compras.cuentaProveedor.index');
    }
    public function getTable() {
        $datos=array();
        $cuentaProveedor=CuentaProveedor::get();
        foreach ($cuentaProveedor as $key => $value) {
            array_push($datos,array(
                "id"=>$value->id,
                "proveedor"=>$value->documento->proveedor->descripcion,
                "numero_doc"=>$value->documento->numero_doc,
                "fecha_doc"=>strval($value->documento->created_at) ,
                "monto"=>$value->documento->total,
                "acta"=>$value->acta,
                "saldo"=>$value->saldo,
                "estado"=>$value->estado
            ));
        }
        return DataTables::of($datos)->toJson();
    }
    public function getDatos(Request $request) {

        $cuenta=CuentaProveedor::findOrFail($request->id);
        return array(
            "id"=>$cuenta->id,
            "proveedor"=>$cuenta->documento->proveedor->descripcion,
            "numero"=>$cuenta->documento->numero_doc,
            "fecha"=>strval($cuenta->documento->created_at) ,
            "monto"=>$cuenta->documento->total,
            "acta"=>$cuenta->acta,
            "saldo"=>$cuenta->saldo,
            "estado"=>$cuenta->estado,
            "detalle"=>CuentaProveedor::findOrFail($request->id)->detallePago
        );
    }
    public function consulta(Request $request)
    {
        $cuentas = DB::table('cuenta_proveedor')
        ->join('compra_documentos', 'compra_documentos.id', '=', 'cuenta_proveedor.compra_documento_id')
        ->join('proveedores', 'proveedores.id', '=', 'compra_documentos.proveedor_id')
        ->when($request->get('proveedor'), function ($query, $request) {
            return $query->where('proveedores.id', $request);
        })
        ->when($request->get('estado'), function ($query, $request) {
            return $query->where('cuenta_proveedor.estado',$request);
        })
        ->select(
            'cuenta_proveedor.*',
            'proveedores.descripcion as proveedor',
            'compra_documentos.numero_doc as numero_doc',
            'compra_documentos.created_at as fecha_doc',
            'compra_documentos.total as monto'
        )->get();
            return $cuentas;
    }
    public function detallePago(Request $request)
    {
        $cuentaProveedor=CuentaProveedor::findOrFail($request->id);
        if($request->pago=="A CUENTA")
        {
            $detallepago=new DetalleCuentaProveedor();
            $detallepago->cuenta_proveedor_id=$cuentaProveedor->id;
            $detallepago->monto=$request->cantidad;
            $detallepago->observacion=$request->observacion;
            $detallepago->fecha=$request->fecha;
            $detallepago->save();
            $cuentaProveedor->saldo=$cuentaProveedor->saldo-$request->cantidad;
            $cuentaProveedor->save();
            $detallepago->saldo =$cuentaProveedor->saldo;
            $detallepago->update();

            if($request->hasFile('file')){
                $detallepago->ruta_imagen = $request->file('file')->store('public/cuenta/proveedor');
                $detallepago->update();
            }
            if($cuentaProveedor->saldo==0)
            {
                $cuentaProveedor->estado='PAGADO';
                $cuentaProveedor->save();
            }
        }
        else{
            $proveedor=$cuentaProveedor->documento->proveedor;
            $cuentasFaltantes=CuentaProveedor::where('estado','PENDIENTE')->get();
            $cantidadRecibida=$request->cantidad;
            foreach ($cuentasFaltantes as $key => $cuenta) {
                    if($cuenta->documento->proveedor->id==$proveedor->id && $cantidadRecibida!=0)
                    {
                        $detallepago=new DetalleCuentaProveedor();
                        $detallepago->cuenta_proveedor_id=$cuenta->id;
                        $detallepago->monto=0;
                        $detallepago->observacion=$request->observacion;
                        $detallepago->fecha=$request->fecha;
                        $detallepago->save();
                        if($cuenta->saldo > $cuenta)
                        {
                            $detallepago->monto=$cantidadRecibida;
                            $cuenta->saldo=$cuenta->saldo-$cantidadRecibida;
                            $cantidadRecibida=0;
                        }
                        else{
                            $detallepago->monto=$cuenta->saldo;
                            $cantidadRecibida=$cantidadRecibida-$cuenta->saldo;
                            $cuenta->saldo=0;
                        }
                        $detallepago->save();
                        $cuenta->save();
                        if($request->hasFile('file')){
                            $detallepago->ruta_imagen = $request->file('file')->store('public/cuenta/proveedor');
                            $detallepago->update();
                        }
                        if($cuenta->saldo==0)
                        {
                            $cuenta->estado='PAGADO';
                            $cuenta->save();
                        }
                    }
            }

        }
    }

    public function reporte($id)
    {
        $cuenta = CuentaProveedor::findOrFail($id);
        $proveedor = $cuenta->documento->proveedor;
        $empresa = Empresa::first();
        $pdf = PDF::loadview('ventas.documentos.impresion.detalle_cuenta_proveedor',[
            'cuenta' => $cuenta,
            'detalles' => $cuenta->detallePago,
            'proveedor' => $proveedor,
            'empresa' => $empresa
            ])->setPaper('a4');
        return $pdf->stream('CUENTA-'.$cuenta->id.'.pdf');
    }
    public function imagen($id)
    {
        $detalle = DetalleCuentaProveedor::find($id);
        $ruta = storage_path().'/app/'.$detalle->ruta_imagen;
        return response()->download($ruta);
    }
}
