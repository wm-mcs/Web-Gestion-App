<?php
namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;




class TipoDeMovimiento extends Model
{

    protected $table ='tipos_de_movimientos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable  = ['name', 'description'];
    protected $appends   = [''];

    
    
    
    
}