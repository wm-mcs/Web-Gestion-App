<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;
use App\Entidades\ImgHome;
use App\Entidades\ImgProyecto;




class Proyecto extends Model
{

    protected $table ='proyectos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description'];



    public function imagenesproyecto()
    {
      return $this->hasMany(ImgProyecto::class,'proyecto_id','id')->where('estado','si');
    }

    
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
        //imagenes asoiadas al proyecto
        $imagenesProyectos = $this->imagenesproyecto;

        //veo si hay alguna que tenga el atributo
        $cantidad_imagenes = $imagenesProyectos->where('foto_principal','si')->count();

        if($cantidad_imagenes === 1)
        {
            $imagen_principal = $imagenesProyectos->where('foto_principal','si')->first();
            

            return $imagen_principal->url_img;
        }
        elseif($cantidad_imagenes === 0)
        {
            $imagen = $imagenesProyectos->first();
            $imagen->foto_principal = 'si';
            $imagen->save();

            return $imagen->url_img;
        }   
        else
        {
            return url().'/imagenes/'.$this->img;
        }    
        
        
    }


    public function getRouteAttribute()
    {
        
        return route('get_pagina_proyecto_individual', [str_replace(" ", "_", $this->name), $this->id]);
    }

    public function getDescriptionParrafoAttribute()
    {
         
         $text =  htmlentities($this->description);
         return   $text;  
    }

     
    
}