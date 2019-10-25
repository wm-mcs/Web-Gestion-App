<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;
use App\Entidades\TipoDeServicio;
use Illuminate\Support\Facades\Cache;
use App\Entidades\UserEmpresa;
use App\Entidades\Socio;
use App\Entidades\SucursalEmpresa;





class EmpresaConSocios extends Model
{

    protected $table ='empresa_con_socios';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description'];
    protected $appends  = ['tipo_servicios','socios_de_la_empresa','sucursuales_empresa','url_img','route_admin'];


    public function servicios_relation()
    {
      return $this->hasMany(TipoDeServicio::class,'empresa_id','id')->where('borrado','no');
    }

        public function getTipoServiciosAttribute()
        {        
           return $this->servicios_relation;
        }


    public function socios()
    {
      return $this->hasMany(Socio::class,'empresa_id','id')->orderBy('name','asc');
    }

        public function getSociosDeLaEmpresaAttribute()
        {        
           return $this->socios;
        }


    public function sucursales()
    {
        return $this->hasMany(SucursalEmpresa::class,'empresa_id','id');
    }

      public function getSucursualesEmpresaAttribute()
      {
        return $this->sucursales;
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