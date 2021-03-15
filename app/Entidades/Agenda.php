<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{

    protected $table = 'agendas';

    protected $fillable = ['name', 'description'];

}
