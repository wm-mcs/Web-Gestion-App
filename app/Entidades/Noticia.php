<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;




class Noticia extends Model
{

    protected $table ='noticias';

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


    public function getUrlImgPortadaAttribute()
    {
        
        return url().'/imagenes/Noticias/'.$this->img.$this->id.'-portada'.'.jpg';
    }

    public function getUrlImgPortadaChicaAttribute()
    {
        
        return url().'/imagenes/Noticias/'.$this->img.$this->id.'-portada-chica'.'.jpg';
    }

    public function getUrlImgAdicionalAttribute()
    {
        
        return url().'/imagenes/Noticias/'.$this->img.$this->id.'-adicional'.'.jpg';
    }

    public function getUrlImgAdicionalChicaAttribute()
    {        
        return url().'/imagenes/Noticias/'.$this->img.$this->id.'-adicional-chica'.'.jpg';
    }


    public function getRouteAttribute()
    {
        
        return route('get_pagina_noticia_individual', [$this->name_slug, $this->id]);
    }

    public function getRouteAdminAttribute()
    {
        
        return route('get_admin_noticias_editar', $this->id);
    }

    public function getNameSlugAttribute()
    {
        return $this->helper_convertir_cadena_para_url($this->name);
    }


    public function getContenidoRenderAttribute()
    {
        $cadena = $this->description;

        //parrafos
        $cadena = str_replace('(P)' ,'<p class="post-individual-p">', $cadena);
        $cadena = str_replace('(/P)' ,'</p>', $cadena);

        //titulos
        $cadena = str_replace('(T)' ,'<h2 class="post-individual-section-titulo">', $cadena);
        $cadena = str_replace('(/T)' ,'</h2>', $cadena);

        //links
        $cadena = str_replace('(A)' ,'<a href="', $cadena);
        $cadena = str_replace('(/A)' ,'">', $cadena);
        $cadena = str_replace('(AT)' ,'', $cadena);
        $cadena = str_replace('(/AT)' ,'</a>', $cadena);

        //img
        $cadena = str_replace('(IMG)' ,'<img class="post-img-secundarias" data-src="', $cadena);
        $cadena = str_replace('(/IMG)' ,'">', $cadena);

        $cadena = str_replace('(IMGT)' ,'<span class="post-img-texto" >', $cadena);
        $cadena = str_replace('(/IMGT)' ,'</span>', $cadena);

        $cadena = str_replace('(YOU)' ,'<div class="video-responsive" > <iframe  src="https://www.youtube.com/embed/', $cadena);
        $cadena = str_replace('(/YOU)' ,'" frameborder="0" allowfullscreen="allowfullscreen"></iframe></div>', $cadena);

        

        return htmlentities($cadena, ENT_QUOTES | ENT_IGNORE, "UTF-8"); 
    }

    //funciones personalizadas para reciclar
    public function helper_convertir_cadena_para_url($cadena)
    {
        $cadena = trim($cadena);
        //quito caracteres - 
        $cadena = str_replace('-' ,' ', $cadena);
        $cadena = str_replace(' ' ,'-', $cadena);
        $cadena = str_replace('?' ,'', $cadena);
        $cadena = str_replace('¿' ,'', $cadena);

        return $cadena;
    }

    

    
}