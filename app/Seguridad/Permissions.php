<?php

namespace App\Seguridad;

use Illuminate\Database\Eloquent\Model;

class Permissions extends Model
{
    protected $table='permissions';
    protected $fillable =['name','guard_name'];
    public $timestamps=true;
}
