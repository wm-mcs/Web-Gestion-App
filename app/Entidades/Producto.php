<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;
use App\Entidades\ImgHome;
use App\Entidades\ProductoImg;
use Illuminate\Support\Facades\Cache;





class Producto extends Model
{

    protected $table ='productos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description'];



    public function imagenes()
    {
      return $this->hasMany(ProductoImg::class,'producto_id','id')->where('estado','si');
    }


    public function getImagenesProductoAttribute()
    {
        return Cache::remember('ImagenesProducto'.$this->id, 15, function() {
                              return $this->imagenes; 
                          }); 
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


    public function getUrlImgMasterAttribute()
    {
        //imagenes asoiadas al proyecto
        $imagenes = $this->imagenes;

        //veo si hay alguna que tenga el atributo
        $cantidad_imagenes = $imagenes->where('foto_principal','si')->count();
        

        if($cantidad_imagenes === 1)
        {
            $imagen_principal = $imagenes->where('foto_principal','si')->first();
            

            return $imagen_principal->url_img;
        }
        elseif($cantidad_imagenes === 0)
        {
            $imagen = $imagenes->first();
            if($imagen == null)
            {
               return 'null';
            }
            
            $imagen->foto_principal = 'si';
            $imagen->save();

            return $imagen->url_img;
        }   
        else
        {
            return url().'/imagenes/'.$this->img;
        }    
        
        
    }

    public function getUrlImgAttribute()
    {
        return Cache::remember('ImagenProducto'.$this->id, 15, function() {
                              return $this->url_img_master; 
                          }); 
    }


    public function getRouteAttribute()
    {
        
        return route('get_pagina_producto_individual', [$this->helper_convertir_cadena_para_url($this->name), $this->id]);
    }

    public function getDescriptionParrafoAttribute()
    {
         
         $text =  htmlentities($this->description);
         return   $text;  
    }

    public function getFechaDeRealizacionAttribute()
    {
         return \Carbon\Carbon::parse($this->fecha);  
    }

    public function getRouteAdminAttribute()
    {
        return route('get_admin_productos_editar',$this->id);
    }


    public function getNameSlugAttribute()
    {
        return $this->helper_convertir_cadena_para_url($this->name);
    }

    //funciones personalizadas para reciclar
    public function helper_convertir_cadena_para_url($cadena)
    {
        $cadena = trim($cadena);
        //quito caracteres - 
        $cadena = str_replace('-' ,' ', $cadena);
        $cadena = str_replace('_' ,' ', $cadena);
        $cadena = str_replace('/' ,' ', $cadena);
        $cadena = str_replace('"' ,' ', $cadena);
        $cadena = str_replace(' ' ,'-', $cadena);
        $cadena = str_replace('?' ,'', $cadena);
        $cadena = str_replace('¿' ,'', $cadena);

        return $cadena;
    }

    public function getPrecioProductoAttribute()
    {
        return round($this->precio, 0);
    }
     
    
}