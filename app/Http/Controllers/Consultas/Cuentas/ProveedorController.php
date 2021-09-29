<?php

namespace App\Http\Controllers\Consultas\Cuentas;

use App\Compras\CuentaProveedor;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProveedorController extends Controller
{
    public function index()
    {
        return view('consultas.cuentas.proveedor');
    }

    public function getTable(Request $request){

        if($request->fecha_desde && $request->fecha_hasta)
        {
            $ordenes = CuentaProveedor::where('estado','!=','ANULADO')->whereBetween(DB::raw('DATE_FORMAT(created_at, "%d-%m-%Y")'), [$request->fecha_desde, $request->fecha_hasta])->orderBy('id', 'desc')->get();
        }
        else
        {
            $ordenes = CuentaProveedor::where('estado','!=','ANULADO')->orderBy('id', 'desc')->get();
        }
        

        
        $coleccion = collect();
        return response()->json([
            'success' => true,
            'ordenes' => $coleccion
        ]);
    }
}
