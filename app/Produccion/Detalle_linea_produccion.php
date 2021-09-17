<?php

namespace App\Produccion;

use Illuminate\Database\Eloquent\Model;

class Detalle_linea_produccion extends Model
{
    protected $table='detalle_lineas_produccion';
    protected $fillable =['linea_produccion_id','maquinaria_equipo_id'];
    public $timestamps=true;

    public function maquinaria_equipo()
	{
	    return $this->belongsTo('App\Almacenes\Maquinaria_equipo');
	}
}
