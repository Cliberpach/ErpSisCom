<?php

namespace App\Http\Controllers\Ventas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CuentaClienteController extends Controller
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
}
