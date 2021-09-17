<?php

namespace App\Produccion;

use Illuminate\Database\Eloquent\Model;
use App\Produccion\Devolucion; // DEVOLUCION 

class OrdenDetalleLote extends Model
{
    protected $table='orden_produccion_lotes'; 
    protected $fillable = [
        'id',
        'orden_produccion_detalle_id',
        'lote_articulo_id',
        'cantidad',
        'tipo_cantidad'
    ];
    public $timestamps=true;

    public function loteArticulo()
	{
	    return $this->belongsTo('App\Compras\LoteArticulo', 'lote_articulo_id');
	}

    public function detalleOrden()
	{
	    return $this->belongsTo('App\Produccion\OrdenDetalle', 'orden_produccion_detalle_id');
	}


    protected static function booted() 
    {
        static::created(function(OrdenDetalleLote $lote){
            // CREAR DEVOLUCION BUEN ESTADO 
            Devolucion::create([
                'detalle_lote_id' => $lote->id,
                'articulo_id' => $lote->loteArticulo->articulo_id,
                'cantidad' => 0,
                'estado' => '1',
            ]);
            // CREA DEVOLUCION EN MAL ESTADO
            Devolucion::create([
                'detalle_lote_id' => $lote->id,
                'articulo_id' => $lote->loteArticulo->articulo_id,
                'cantidad' => 0,
                'estado' => '0',
            ]);
        });
    }

}