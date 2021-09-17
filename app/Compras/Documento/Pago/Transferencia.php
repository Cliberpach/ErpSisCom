<?php

namespace App\Compras\Documento\Pago;

use Illuminate\Database\Eloquent\Model;

class Transferencia extends Model
{
    protected $table = 'compra_documento_transferencia';
    public $timestamps = true;
    protected $fillable = [
            'documento_id',
            'id_banco_proveedor',
            'id_banco_empresa',

            'ruta_archivo',
            'nombre_archivo',
            'fecha_pago',
            'monto',
            'moneda',

            'moneda_empresa',
            'moneda_proveedor',
            
            'tipo_cambio',
            'cambio',
            
            'observacion',
            'estado'
        ];

    public function bancosProveedor()
    {
        return $this->belongsTo('App\Compras\Banco','id_banco_proveedor');
    }

    public function bancosEmpresa()
    {
        return $this->belongsTo('App\Mantenimiento\Empresa\Banco','id_banco_empresa');
    }

    public function documento()
    {
        return $this->belongsTo('App\Compras\Documento\Documento');
    }
}
