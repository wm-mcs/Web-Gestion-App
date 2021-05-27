<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $table    = 'reservas';
    protected $fillable = ['name', 'description'];
}
