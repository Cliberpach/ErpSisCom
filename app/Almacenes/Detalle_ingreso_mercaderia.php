<?php

namespace App\Almacenes;

use Illuminate\Database\Eloquent\Model;

class Detalle_ingreso_mercaderia extends Model
{
    protected $table='detalle_ingresos_mercaderia';
    protected $fillable =['ingreso_mercaderia_id','peso_bruto','peso_neto','observacion'];
    public $timestamps=true;
}
