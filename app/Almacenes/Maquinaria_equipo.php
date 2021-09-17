<?php

namespace App\Almacenes;

use Illuminate\Database\Eloquent\Model;

class Maquinaria_equipo extends Model
{
    protected $table='maquinarias_equipos';
    protected $fillable =['tipo','nombre','serie','tipocorriente','caracteristicas','ruta_imagen','nombre_imagen','vidautil','estado'];
    public $timestamps=true;
}
