<?php

namespace App\Produccion;

use Illuminate\Database\Eloquent\Model;

class DetalleNotaProduccion extends Model
{
    protected $table='detalle_nota_produccion';
    protected $fillable = [
          'nota_produccion_id',
          'articulo_id',
          'cantidad',
          'comentario'
        ];

    public $timestamps=true;
}
