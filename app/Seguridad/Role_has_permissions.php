<?php

namespace App\Seguridad;;

use Illuminate\Database\Eloquent\Model;

class Role_has_permissions extends Model
{
    protected $table='role_has_permissions';
    protected $fillable =['permission_id','role_id'];
    public $timestamps=false;
}
