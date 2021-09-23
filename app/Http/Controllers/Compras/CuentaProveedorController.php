<?php

namespace App\Http\Controllers\Compras;

use App\Compras\CuentaProveedor;
use App\Compras\DetalleCuentaProveedor;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
                        if($cuenta->saldo>$cuenta)
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
                        if($cuenta->saldo==0)
                        {
                            $cuenta->estado='PAGADO';
                            $cuenta->save();
                        }
                    }
            }

        }
    }
}
