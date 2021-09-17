<?php

namespace App\Compras\Documento\Pago;

use Illuminate\Database\Eloquent\Model;

class PagoDetalle extends Model
{
    protected $table = 'documento_pago_detalle';
    public $timestamps = true;
    protected $fillable = [
            'pago_id',
            'detalle_id',
        ];

    public function pago()
    {
        return $this->belongsTo('App\Compras\Documento\Pago\Pago');
    }

    public function detalle()
    {
        return $this->belongsTo('App\Compras\Documento\Pago\Detalle');
    }

}
