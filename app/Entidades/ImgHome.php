<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;




class ImgHome extends Model
{

    protected $table ='imgs_home';

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