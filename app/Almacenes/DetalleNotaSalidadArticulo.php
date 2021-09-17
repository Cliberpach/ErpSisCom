<?php

namespace App\Almacenes;

use Illuminate\Database\Eloquent\Model;

class DetalleNotaSalidadArticulo extends Model
{
    protected $table = 'detalle_nota_salidad_articulo';
    protected $fillable = [
        'id',
        'nota_salidad_id',
        'lote_id',
        'cantidad',
        'articulo_id'
    ];
    public $timestamps = true;
}
