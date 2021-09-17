<?php

namespace App\Ventas;

use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    protected $table = 'nota_electronica';
    protected $fillable = [
        'documento_id',
        'tipDocAfectado',
        'numDocfectado',
        'codMotivo',
        'desMotivo',

        'tipoDoc',
        'fechaEmision',
        'tipoMoneda',

        //DATOS DE LA EMPRESA
        'ruc_empresa',
        'empresa',
        'direccion_fiscal_empresa',
        'empresa_id',
        //CLIENTE
        'cod_tipo_documento_cliente',
        'tipo_documento_cliente',
        'documento_cliente',
        'direccion_cliente',
        'cliente',

        'sunat',
        'tipo_nota',

        'correlativo',
        'serie',

        'ruta_comprobante_archivo',
        'nombre_comprobante_archivo',

        'mtoOperGravadas',
        'mtoIGV',
        'totalImpuestos',
        'mtoImpVenta',
        'ublVersion',


        'guia_tipoDoc',
        'guia_nroDoc',
        'code',
        'value',
        'estado',
    ];


}
