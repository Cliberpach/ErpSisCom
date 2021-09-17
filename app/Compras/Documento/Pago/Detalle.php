<?php

namespace App\Compras\Documento\Pago;

use Illuminate\Database\Eloquent\Model;

class Detalle extends Model
{
    protected $table = 'compra_documento_pago_detalle';
    public $timestamps = true;
    protected $fillable = [
        'caja_id',
        'monto',
        // 'tipo_pago',
        'pago_id'
    ];

    public function caja()
    {
        return $this->belongsTo('App\Pos\Caja');
    }

    public function pago()
    {
        return $this->belongsTo('App\Compras\Documento\Pago\Pago');
    }

}
