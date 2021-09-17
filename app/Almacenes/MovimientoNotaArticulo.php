<?php

namespace App\Almacenes;

use Illuminate\Database\Eloquent\Model;

class MovimientoNotaArticulo extends Model
{
    protected $table = 'movimiento_nota_articulo';
    protected $fillable = [
        'id',
        'lote_id',
        'cantidad',
        'observacion',
        'usuario_id',
        'nota_id',
        'movimiento',
        'articulo_id'
    ];
    public $timestamps = true;
}
