<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;

    protected $fillable = [
        'usuario', 'email', 'password','nombre_imagen','ruta_imagen','colaborador_id'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function cotizaciones()
    {
        return $this->hasMany('App\Ventas\Cotizacion');
    }

    public function empleado()
    {
        return $this->belongsTo('App\Mantenimiento\Colaborador\Colaborador','colaborador_id');
    }
}
