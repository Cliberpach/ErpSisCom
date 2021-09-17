<?php

namespace App\Produccion;

use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
    protected $table='orden_produccion';
    protected $fillable = [
          'programacion_id',
          
          'producto_id',
          'codigo_producto',
          'descripcion_producto',
          'fecha_produccion',
          'cantidad',
          
          'version',
          'codigo',
          'tiempo_proceso',

          'fecha_orden',
          'observacion', //POR BORRAR O INGRESARLO
          'conformidad', //[0=>PENDIENTE , 1 => APROBADO , 2 => NULO]
          'editable',// [0=>NUEVO , 1 => EDITAR , 2 => NO NECESITA (COMPLETADO)]
          'atendido', //[ 0 => NO SE AGREGAR NINGUN DETALLE A LA ORDEN , 1 => SE AGREGADO UN DETALLE A LA ORDEN DE PRODUCCION]
          'estado',
        ];
        
    public $timestamps=true;

    public function programacion()
	{
	    return $this->belongsTo('App\Produccion\Programacion_produccion','programacion_id');
	}
}
