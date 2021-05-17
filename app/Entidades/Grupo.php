<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    protected $table    = 'grupos';
    protected $fillable = ['name', 'description'];
    protected $appends  = ['actividad'];
}
