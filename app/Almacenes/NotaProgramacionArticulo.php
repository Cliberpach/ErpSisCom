<?php

namespace App\Almacenes;

use Illuminate\Database\Eloquent\Model;

class NotaProgramacionArticulo extends Model
{
    protected $table = 'nota_programacion_articulo';
    protected $fillable = [
        'notapro_id',
        'articulo_id',
        'comentario'
    ];
    public $timestamps = true;
}
