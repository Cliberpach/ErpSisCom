<?php

namespace App\Produccion;

use Illuminate\Database\Eloquent\Model;

class Devolucion extends Model
{
    protected $table='orden_produccion_devoluciones';
    protected $fillable = [
          'detalle_lote_id',
          'articulo_id',
          'cantidad',
          'estado',
        ];
        
    public $timestamps=true;

    public function detalleLote()
	{
	    return $this->belongsTo('App\Produccion\OrdenDetalleLote', 'detalle_lote_id');
	}

}
