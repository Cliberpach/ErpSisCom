<?php

namespace App\Produccion;

use Illuminate\Database\Eloquent\Model;

class OrdenDetalle extends Model
{
    protected $table='orden_produccion_detalles';
    protected $fillable = [
          'orden_id',
          'articulo_id',
          'cantidad_produccion',
          'cantidad_produccion_completa',
          'cantidad_excedida',
          'completado',
        //   'almacen_correcto_id',
        //   'cantidad_devuelta_correcta',
        //   'observacion_correcta',
        //   'almacen_incorrecto_id',
        //   'cantidad_devuelta_incorrecta',
        //   'observacion_incorrecta',
        //   'operacion',
          
        ];

    public $timestamps=true;

    public function orden()
	{
	    return $this->belongsTo('App\Produccion\Orden', 'orden_id');
	}

    public function productoDetalle()
	{
	    return $this->belongsTo('App\Almacenes\ProductoDetalle', 'articulo_id');
	}

    public function articulo()
	{
	    return $this->belongsTo('App\Compras\Articulo', 'articulo_id');
	}

    public function almacenCorrecto()
	{
	    return $this->belongsTo('App\Almacenes\Almacen', 'almacen_correcto_id');
	}

    public function almacenIncorrecto()
	{
	    return $this->belongsTo('App\Almacenes\Almacen', 'almacen_incorrecto_id');
	}
}
