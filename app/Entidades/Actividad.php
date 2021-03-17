<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    protected $table    = 'actividades';
    protected $fillable = ['name', 'description'];
}
