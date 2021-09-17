<?php

namespace App\Ventas\Documento\Pago;

use Illuminate\Database\Eloquent\Model;

class PagoDetalle extends Model
{
    protected $table = 'cotizacion_documento_pago_detalle_cajas';
    public $timestamps = true;
    protected $fillable = [
            'pago_id',
            'caja_id',
        ];

    public function caja()
    {
        return $this->belongsTo('App\Ventas\Documento\Pago\Caja','caja_id');
    }

    public function pago()
    {
        return $this->belongsTo('App\Ventas\Documento\Pago\Pago','pago_id');
    }

}
