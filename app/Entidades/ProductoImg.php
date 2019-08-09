<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;




class ProductoImg extends Model
{

    protected $table ='producto_imagenes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description'];

    
    public function getUrlImgAttribute()
    {
        
        return url().'/imagenes/Productos/'.$this->img.'-'.$this->id.'.jpg';
    }

    public function getUrlImgChicaAttribute()
    {
        
        return url().'/imagenes/Productos/'.$this->img.'-'.$this->id.'-chica.jpg';
    }


    public function getPathImgAttribute()
    {
        
        return  public_path().'/imagenes/Productos/'.$this->img.'-'.$this->id.'.jpg';
    }

    public function getPathImgChicaAttribute()
    {
        
        return  public_path().'/imagenes/Productos/'.$this->img.'-'.$this->id.'-chica.jpg';
    }
    
}