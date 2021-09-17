<?php

namespace App\Almacenes;

use Illuminate\Database\Eloquent\Model;

class SubFamilia extends Model
{
    protected $table = 'subfamilias';
    protected $fillable = [
        'descripcion',
        'familia_id',
        'estado'
    ];
    public $timestamps = true;
    
    public function familia()
    {
        return $this->belongsTo('App\Almacenes\Familia', 'familia_id');
    }

    public function productos()
    {
        return $this->hasMany('App\Almacenes\Producto');
    }
}
