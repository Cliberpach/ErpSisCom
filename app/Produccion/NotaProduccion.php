<?php

namespace App\Produccion;

use Illuminate\Database\Eloquent\Model;

class NotaProduccion extends Model
{
    protected $table='nota_produccion';
    protected $fillable = [
          'programacion_produccion_id',
          'user_id',
          'comentario',
          'fecha_registro',
          'emision',
          'estado'
        ];

    public $timestamps=true;

}
