<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;





class EmpresaConSocios extends Model
{

    protected $table ='empresa_con_socios';

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
        
        return url().'/imagenes/Empresa/'.$this->id.'-logo_empresa_socios'.'.png';
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


    public function getRouteAdminAttribute()
    {
        
        return route('get_admin_empresas_gestion_socios_editar', $this->id);
    }


    public function getRoutePanelEmpresaAttribute()
    {
        return route('get_empresa_panel_de_gestion',$this->id);
    }



    
    
}