<?php

namespace App\Compras\Documento\Pago;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $table = 'compra_documento_pagos';
    public $timestamps = true;
    protected $fillable = [
            'observacion',
            'documento_id',
            'tipo_pago',
            'estado',
        ];

    public function documento()
    {
        return $this->belongsTo('App\Compras\Documento\Documento');
    }

}
