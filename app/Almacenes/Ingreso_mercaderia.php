<?php

namespace App\Almacenes;

use Illuminate\Database\Eloquent\Model;

class Ingreso_mercaderia extends Model
{
    protected $table='ingresos_mercaderia';
    protected $fillable =['factura','fecha_ingreso','articulo_id','lote','fecha_produccion','fecha_vencimiento','proveedor_id','peso_embalaje_dscto','usuario_id','estado'];
    public $timestamps=true;
}
