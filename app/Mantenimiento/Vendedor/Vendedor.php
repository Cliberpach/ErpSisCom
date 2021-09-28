<?php

namespace App\Mantenimiento\Vendedor;

use App\Mantenimiento\Persona\PersonaVendedor;
use Illuminate\Database\Eloquent\Model;

class Vendedor extends Model
{
    protected $table = 'vendedores';
    protected $fillable =[
        'persona_trabajador_id'
    ];

    public function persona_trabajador()
    {
        return $this->belongsTo('App\PersonaTrabajador','persona_trabajador_id');
    }

}
