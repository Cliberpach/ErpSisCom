<?php

namespace App\Ventas;

use Illuminate\Database\Eloquent\Model;

class DetalleCuentaCliente extends Model
{
    protected $table="detalle_cuenta_cliente";
    protected $fillable=[
        'cuenta_cliente_id',
        'fecha',
        'observacion',
        'monto',
    ];
    public function cuenta_cliente()
    {
        return $this->belongsTo(CuentaCliente::class,'cuenta_cliente_id');
    }
}
