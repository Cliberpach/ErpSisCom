<?php

namespace App\Ventas\Documento\Pago;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{

    protected $table = 'cotizacion_documento_pagos';
    public $timestamps = true;
    protected $fillable = [
            'documento_id',
            'total',
            'observacion',
            'tipo_pago',
            'estado'
        ];


    public function documento()
    {
        return $this->belongsTo('App\Ventas\Documento');
    }
    public function caja()
    {
        return $this->belongsTo('App\Pos\Caja');
    }

    
}
