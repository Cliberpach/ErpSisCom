<?php

namespace App\Almacenes;

use App\Almacenes\Producto;
use Illuminate\Database\Eloquent\Model;

use App\Produccion\OrdenDetalle;
use App\Compras\Articulo;

class LoteProducto extends Model
{
    protected $table = 'lote_productos';
    protected $fillable = [
        'codigo_lote',
        'documento_compra_id',
        'nota_ingreso_id',
        'producto_id',

        'cantidad',
        'cantidad_logica',
        
        'fecha_vencimiento',
        'fecha_entrega',
        'observacion',

        'confor_almacen',
        'confor_produccion',

        'estado'
    ];
    
    public $timestamps = true;

    public function producto()
    {
        return $this->belongsTo('App\Almacenes\Producto','producto_id');
    }

    public function documento_compra()
    {
        return $this->belongsTo('App\Compras\Documento\Detalle','compra_documento_id');
    }

    public function nota()
    {
        return $this->belongsTo('App\Almacenes\NotaIngreso','nota_ingreso_id','id');
    }

    //EVENTO AL CREAR Y AL MODIFICAR
    protected static function booted()
    {
        static::saved(function(LoteProducto $loteProducto){          
            //RECORRER DETALLE NOTAS
            $cantidadProductos = LoteProducto::where('producto_id',$loteProducto->producto_id)->where('estado','1')->sum('cantidad');
            //ACTUALIZAR EL STOCK DEL PRODUCTO
            $producto = Producto::findOrFail($loteProducto->producto_id);
            $producto->stock = $cantidadProductos ? $cantidadProductos : 0.00;
            $producto->update();
        });

        static::updated(function(LoteProducto $loteProducto){          
            //RECORRER DETALLE NOTAS
            $cantidadProductos = LoteProducto::where('producto_id',$loteProducto->producto_id)->where('estado','1')->sum('cantidad');
            //ACTUALIZAR EL STOCK DEL PRODUCTO
            $producto = Producto::findOrFail($loteProducto->producto_id);
            $producto->stock = $cantidadProductos ? $cantidadProductos : 0.00;
            $producto->update();
        });

        static::deleted(function(LoteProducto $loteProducto){          
            //RECORRER DETALLE NOTAS
            $cantidadProductos = LoteProducto::where('producto_id',$loteProducto->producto_id)->where('estado','1')->sum('cantidad');
            //ACTUALIZAR EL STOCK DEL PRODUCTO
            $producto = Producto::findOrFail($loteProducto->producto_id);
            $producto->stock = $cantidadProductos ? $cantidadProductos : 0.00;
            $producto->update();
        });
    }
}
