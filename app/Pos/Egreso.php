<?php

namespace App\Pos;

use Illuminate\Database\Eloquent\Model;

class Egreso extends Model
{
    protected $table="egreso";
    protected $fillable=[
        'descripcion','importe','estado'
    ];
    public $timestamps=true;
}
