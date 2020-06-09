<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;




class Pais extends Model
{

    protected $table ='paises';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable  = ['name', 'description'];
    protected $appends   = ['url_img'];

    
    public function getUrlImgAttribute()
    { 
        return url().'/imagenes/Paises/'. str_replace(' ' ,'-', $this->name). '.png';
    }

    
    
}