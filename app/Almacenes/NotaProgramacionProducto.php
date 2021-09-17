<?php

namespace App\Almacenes;

use Illuminate\Database\Eloquent\Model;

class NotaProgramacionProducto extends Model
{
    protected $table = 'nota_programacion_producto';
    protected $fillable = [
        'programacion_produccion_id',
        'user_id'
    ];
    public $timestamps = true;
}
