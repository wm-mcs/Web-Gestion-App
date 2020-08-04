<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;




class DetalleMovimientoPadreDeEmpresa extends Model
{
    protected $table ='movimientos_empresa_detalles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable  = ['name', 'description'];
    protected $appends   = [''];
    
}
