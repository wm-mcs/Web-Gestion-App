<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;




class MovimientoPadreDeEmpresa extends Model
{
    protected $table ='movimientos_de_empresa';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable  = ['name', 'description'];
    protected $appends   = [''];
    
}


