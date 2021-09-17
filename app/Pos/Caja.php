<?php

namespace App\Pos;

use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    protected $table = 'pos_caja_chica';
    protected $fillable = ['cierre',
    'estado',
    'num_referencia',
    'saldo_inicial',
    'colaborador_id',
    'moneda',
    'uso'
    ];
    public $timestamps = true;

    public function empleado()
    {
        return $this->belongsTo('App\Mantenimiento\Colaborador\Colaborador','colaborador_id');
    }
}
