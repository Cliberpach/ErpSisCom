<?php

namespace App\Ventas\Documento\Pago;

use Illuminate\Database\Eloquent\Model;

class Detalle extends Model
{

    protected $table = 'cotizacion_documento_pago_detalles';
    public $timestamps = true;
    protected $fillable = [
            'pago_id',
            // 'caja_id',

            'ruta_archivo',
            'nombre_archivo',
            'fecha_pago',
            'monto',
            'moneda',

            // 'fecha_venta',
            'tipo_pago',
            'observacion',
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
    public function pago()
    {
        return $this->belongsTo('App\Ventas\Documento\Pago\Pago');
    }

    
}
