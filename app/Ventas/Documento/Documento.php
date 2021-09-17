<?php

namespace App\Ventas\Documento;

use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    protected $table = 'cotizacion_documento';
    protected $fillable = [
        //DATOS DE LA EMPRESA
        'ruc_empresa',
        'empresa',
        'direccion_fiscal_empresa',
        'empresa_id',
        //CLIENTE
        'tipo_documento_cliente',
        'documento_cliente',
        'direccion_cliente',
        'cliente',
        'cliente_id',
    
        'moneda',
        'numero_doc',
        'fecha_documento',
        'fecha_atencion',
        'sub_total',
        'total_igv',
        'total',
        'user_id',
        'estado',
        'igv',
        'igv_check',
        'tipo_venta',
        'cotizacion_venta',
        'sunat',
        'correlativo',
        'serie',
        'ruta_comprobante_archivo',
        'nombre_comprobante_archivo'
    ];



    public function detalles()
    {
        return $this->hasMany('App\Ventas\Documento\Detalle','documento_id');
    }


    public function empresaEntidad()
    {
        return $this->belongsTo('App\Mantenimiento\Empresa\Empresa', 'empresa_id');
    }

    public function clienteEntidad()
    {
        return $this->belongsTo('App\Ventas\Cliente', 'cliente_id');
    }
    

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function tipo_pago()
    {
        return $this->belongsTo('App\Ventas\TipoPago','tipo_pago_id');
    }

    public function nombreTipo(): string
    {
        $venta = tipos_venta()->where('id', $this->tipo_venta)->first();
        if (is_null($venta))
            return "-";
        else
            return strval($venta->nombre);
    }

    public function descripcionTipo(): string
    {
        $venta = tipos_venta()->where('id', $this->tipo_venta)->first();
        if (is_null($venta))
            return "-";
        else
            return strval($venta->descripcion);
    }

    public function tipoOperacion(): string
    {
        $venta = tipos_venta()->where('id', $this->tipo_venta)->first();
        if (is_null($venta))
            return "-";
        else
            return strval($venta->operacion);
    }

    public function tipoDocumento(): string
    {
        $venta = tipos_venta()->where('id', $this->tipo_venta)->first();
        if (is_null($venta))
            return "-";
        else
            return strval($venta->simbolo);
    }

    public function simboloMoneda(): string
    {
        $moneda = tipos_moneda()->where('id', $this->moneda)->first();
        if (is_null($moneda))
            return "-";
        else
            return $moneda->parametro;
    }


    public function tipoDocumentoCliente(): string
    {
        $documento = tipos_documento()->where('simbolo', $this->tipo_documento_cliente)->first();
        if (is_null($documento))
            return "-";
        else
            return $documento->parametro;
    }
}
