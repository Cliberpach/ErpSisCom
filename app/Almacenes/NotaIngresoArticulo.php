<?php

namespace App\Almacenes;

use Illuminate\Database\Eloquent\Model;

class NotaIngresoArticulo extends Model
{
    protected $table = 'nota_ingreso_articulo';
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
