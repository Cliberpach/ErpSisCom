<?php

namespace App\Produccion;

use Illuminate\Database\Eloquent\Model;

class Linea_produccion extends Model
{
    protected $table='lineas_produccion';
    protected $fillable =['nombre_linea','cantidad_personal','ruta_imagen','nombre_imagen','ruta_archivo_word','archivo_word'];
    public $timestamps=true;
}
