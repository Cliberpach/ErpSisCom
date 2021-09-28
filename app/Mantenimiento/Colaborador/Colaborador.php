<?php

namespace App\Mantenimiento\Colaborador;

use App\Mantenimiento\Persona\Persona;
use App\PersonaTrabajador;
use Illuminate\Database\Eloquent\Model;

class Colaborador extends Model
{
    protected $table = 'colaboradores';
    protected $fillable =[
        'persona_trabajador_id'
    ];
    public $timestamps=true;
    public function persona_trabajador()
    {
        return $this->belongsTo('App\PersonaTrabajador','persona_trabajador_id');
    }
}
