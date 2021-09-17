<?php

namespace App\Almacenes;

use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    protected $table = 'articulos';
    protected $fillable =[
        'categoria_id', 
        'codigo_fabrica',
        'almacen_id',
        'presentacion',
        'descripcion',
        'stock',
        'stock_min',
        'precio_compra',
        'codigo_barra',
        'estado',
        'unidad_medida',
    ];
    public $timestamps = true;

    public function categoria()
    {
        return $this->belongsTo('App\Compras\Categoria', 'categoria_id');
    }

    public function almacen()
    {
        return $this->belongsTo('App\Almacenes\Almacen', 'almacen_id');
    }

    public function cotizacion_detalles()
    {
        return $this->hasMany('App\Ventas\CotizacionDetalle');
    }

    // HELPERS
    function getDescripcionCompleta()
    {
        return $this->codigo_fabrica.' - '.$this->descripcion;
    }

    public function getMedida(): string
    {
        $medida = unidad_medida()->where('id', $this->unidad_medida)->first();
        if (is_null($medida))
            return "-";
        else
            return $medida->simbolo;
    }
}
