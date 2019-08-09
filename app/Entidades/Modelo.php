<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;




class Modelo extends Model
{

    protected $table ='modelos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description'];









    /**
     * PAra busqueda por nombre
     */
    public function scopeName($query, $name)
    {
        //si el paramatre(campo busqueda) esta vacio ejecutamos el codigo
        /// trim() se utiliza para eliminar los espacios.
        ////Like se usa para busqueda incompletas
        /////%% es para los espacios adelante y atras
        if (trim($name) !="")
        {                        
           $query->where('name', "LIKE","%$name%"); 
        }
        
    }

    public function scopeActive($query)
    {
                               
           $query->where('estado', "si"); 
                
    }


    public function getUrlImgAttribute()
    {
        
        return url().'/imagenes/'.$this->img;
    }


    public function getRouteAttribute()
    {
        
        return route('get_pagina_noticia_individual', [str_replace(" ", "_", $this->name), $this->id]);
    }

    

    
}