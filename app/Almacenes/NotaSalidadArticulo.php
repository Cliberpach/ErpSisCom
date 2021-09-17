<?php

namespace App\Almacenes;

use Illuminate\Database\Eloquent\Model;

class NotaSalidadArticulo extends Model
{
    protected $table = 'nota_salidad_articulo';
    protected $fillable = [
        'numero',
        'fecha',
        'origen',
        'destino',
        'usuario',
        'estado'
    ];
    public $timestamps = true;
}
