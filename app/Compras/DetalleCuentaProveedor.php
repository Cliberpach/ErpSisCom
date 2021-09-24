<?php

namespace App\Compras;

use Illuminate\Database\Eloquent\Model;

class DetalleCuentaProveedor extends Model
{
    protected $table="detalle_cuenta_proveedor";
    protected $fillable=[
        'cuenta_proveedor_id',
        'fecha',
        'observacion',
        'monto'
    ];
    public function cuenta_proveedor()
    {
        return $this->belongsTo(CuentaProveedor::class,'cuenta_proveedor_id');
    }

}
