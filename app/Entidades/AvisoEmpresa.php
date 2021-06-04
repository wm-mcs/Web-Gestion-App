<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;

class AvisoEmpresa extends Model
{
    protected $table    = 'avisos_empresa';
    protected $fillable = ['name', 'description'];
}
