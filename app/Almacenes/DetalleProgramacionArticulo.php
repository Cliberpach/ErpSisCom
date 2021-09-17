<?php

namespace App\Almacenes;

use Illuminate\Database\Eloquent\Model;

class DetalleProgramacionArticulo extends Model
{
    protected $table = 'detalle_programacion_articulo';
    protected $fillable = [
        'notapro_articulo_id',
        'lote_id',
        'cantidad'
    ];
    public $timestamps = true;
}
