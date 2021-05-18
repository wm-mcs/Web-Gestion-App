<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;

class GrupoSocioRelacion extends Model
{
    protected $table    = 'grupos_socios';
    protected $fillable = ['name', 'description'];

}
