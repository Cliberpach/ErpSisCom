<?php

namespace App\Produccion;

use Illuminate\Database\Eloquent\Model;

class Programacion_produccion extends Model
{
    protected $table='programacion_produccion';
    protected $fillable =[
                'id',
                'producto_id',
                // 'fecha_creacion',
                'fecha_produccion',
                'fecha_termino',
                'cantidad_programada',
                // 'cantidad_producida',
                'observacion',
                // 'usuario_id',
                'produccion', // [ 0 => NO SE AGREGAR NINGUN DETALLE A LA ORDEN , 1 => SE AGREGADO UN DETALLE A LA ORDEN DE PRODUCCION]
                'estado',
                // 'created_at',
                // 'updated_at'
            ];
    public $timestamps=true;

    public function producto()
	{
	    return $this->belongsTo('App\Almacenes\Producto','producto_id');
	}
}
