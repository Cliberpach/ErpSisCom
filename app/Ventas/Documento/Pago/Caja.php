<?php

namespace App\Ventas\Documento\Pago;

use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    protected $table = 'cotizacion_documento_pago_cajas';
    public $timestamps = true;
    protected $fillable = [
            'caja_id',
            'monto',
            'estado',
        ];

    public function caja()
    {
        return $this->belongsTo('App\Pos\Caja');
    }

}
