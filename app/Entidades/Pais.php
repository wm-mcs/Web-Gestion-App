<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;




class Pais extends Model
{

    protected $table ='pises';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description'];

    
    public function getUrlImgAttribute()
    { 
        return url().'/imagenes/'.$this->img;
    }
    
}