<?php

namespace App\Compras;

use Illuminate\Database\Eloquent\Model;
use App\Almacenes\Producto;
class LoteProductoCompras extends Model
{
    protected $table = 'lote_productos_compras';
    protected $fillable = [
        'detalle_id',
        'lote',
        'producto_id',
        'codigo_producto',
        'descripcion_producto',
        'cantidad',
        'cantidad_logica',
        'fecha_vencimiento',
        'estado'
    ];
    public $timestamps = true;

    public function producto()
    {
        return $this->belongsTo('App\Almacenes\Producto','producto_id');
    }

    //EVENTO AL CREAR - ACTUALIZAR STOCK DEL Producto
    protected static function booted() 
    {
        static::creating(function(LoteProductoCompras $lote){
            //ACTUALIZAR EL STOCK DEL ARTICULO
            $producto = Producto::findOrFail($lote->producto_id);
            $producto->stock = $producto->stock + $lote->cantidad;
            $producto->update();
        });
    }

}
