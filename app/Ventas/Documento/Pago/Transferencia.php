<?php

namespace App\Ventas\Documento\Pago;

use Illuminate\Database\Eloquent\Model;

class Transferencia extends Model
{
    protected $table = 'cotizacion_documento_pago_transferencias';
    public $timestamps = true;
    protected $fillable = [
            'documento_id',
            'id_banco_empresa',

            'ruta_archivo',
            'nombre_archivo',
            'fecha_pago',
            'monto',
            'moneda',

            'observacion',
            'estado'
        ];


    public function bancosEmpresa()
    {
        return $this->belongsTo('App\Mantenimiento\Empresa\Banco','id_banco_empresa');
    }

    public function documento()
    {
        return $this->belongsTo('App\Compras\Documento\Documento');
    }
}
