<?php

namespace App\Http\Controllers\Reportes;

use App\Compras\Documento\Detalle;
use App\Http\Controllers\Controller;
use App\Ventas\Documento\Detalle as DocumentoDetalle;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProductoController extends Controller
{
    public function informe()
    {
        return view('reportes.almacenes.producto.informe');
    }

    public function llenarCompras($id)
    {
        $compras = Detalle::where('producto_id', $id)->orderBy('id', 'desc')->get();
        $coleccion = collect([]);
        foreach($compras as $producto) {
            $coleccion->push([
                'proveedor' => $producto->documento->proveedor->descripcion,
                'documento' => $producto->documento->tipo_compra,
                'numero' => $producto->documento->serie_tipo.'-'.$producto->documento->numero_tipo,
                'fecha_emision' => $producto->documento->fecha_emision,
                'cantidad' => $producto->cantidad,
                'precio' => $producto->precio_soles,
                'lote' => $producto->lote,
                'fecha_vencimiento' => $producto->fecha_vencimiento,
            ]);
        }
        return DataTables::of($coleccion)->make(true);
    }

    public function llenarVentas($id)
    {
        $ventas = DocumentoDetalle::orderBy('id', 'desc')->get();
        $coleccion = collect([]);
        foreach($ventas as $producto) {
            if($producto->lote->producto_id == $id)
            {
                $coleccion->push([
                    'cliente' => $producto->documento->clienteEntidad->nombre,
                    'documento' => $producto->documento->nombreTipo(),
                    'numero' => $producto->documento->serie.'-'.$producto->documento->correlativo,
                    'fecha_emision' => $producto->documento->fecha_atencion,
                    'cantidad' => $producto->cantidad,
                    'precio' => $producto->precio_nuevo,
                    'lote' => $producto->lote->codigo_lote,
                    'fecha_vencimiento' => $producto->documento->fecha_vencimiento,
                ]);
            }
        }
        return DataTables::of($coleccion)->make(true);
    }
}
