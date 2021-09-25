<?php

namespace App\Mantenimiento\Colaborador;

use App\Mantenimiento\Persona\Persona;
use Illuminate\Database\Eloquent\Model;

class Colaborador extends Model
{
    protected $table = 'colaboradores';
    protected $fillable =[
        'persona_trabajador_id'
    ];

    public function persona_trabajador()
    {
        return $this->belongsTo(PersonaTrabajador::class,'persona_trabajador_id');
    }
}
