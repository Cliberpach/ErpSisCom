<?php

namespace App\Ventas;

use Illuminate\Database\Eloquent\Model;

class NotaDetalle extends Model
{
    protected $table = 'nota_electronica_detalle';
    protected $fillable = [
        'nota_id',
        'codProducto',
        'unidad',
        'descripcion',
        'cantidad',

        'mtoBaseIgv',
        'porcentajeIgv',
        'igv',
        'tipAfeIgv',

        'totalImpuestos',
        'mtoValorVenta',
        'mtoValorUnitario',
        'mtoPrecioUnitario',
    ];


}