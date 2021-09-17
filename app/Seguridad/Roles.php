<?php

namespace App\Seguridad;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $table='roles';
    protected $fillable =['name','guard_name'];
    public $timestamps=true;
}
