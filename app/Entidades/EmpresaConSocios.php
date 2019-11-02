<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;
use App\Entidades\TipoDeServicio;
use Illuminate\Support\Facades\Cache;
use App\Entidades\UserEmpresa;
use App\Entidades\Socio;
use App\Entidades\SucursalEmpresa;
use App\Entidades\MovimientoEstadoDeCuentaEmpresa;
use Illuminate\Support\Facades\Session;





class EmpresaConSocios extends Model
{

    protected $table ='empresa_con_socios';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description'];
    protected $appends  = ['tipo_servicios',
                           'socios_de_la_empresa',
                           'sucursuales_empresa',
                           'url_img',
                           'route_admin',
                           'movimientos_estado_de_cuenta_empresa',
                           'estado_de_cuenta_saldo_pesos',
                           'estado_de_cuenta_saldo_dolares'];


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
        return Cache::remember('sucursales_empresa'.$this->id, 60, function() {
                              return $this->sucursales;
                          }); 
      }

    public function movimientos_estado_de_cuenta()
    {
        return $this->hasMany(MovimientoEstadoDeCuentaEmpresa::class,'empresa_id','id')->where('borrado','no');
    }

      public function getMovimientosEstadoDeCuentaEmpresaAttribute()
      {
        return $this->movimientos_estado_de_cuenta;
      } 

      

    public function getEstadoDeCuentaSaldoPesosAttribute()
    {
        

        $Debe    = $this->movimientos_estado_de_cuenta_empresa->where('tipo_saldo','deudor')
                                                ->where('moneda','$')                                                
                                                ->sum('valor');

        $Acredor = $this->movimientos_estado_de_cuenta_empresa->where('tipo_saldo','acredor') 
                                                ->where('borrado','no')                                 
                                                ->where('moneda','$')
                                                ->sum('valor');


        return round($Debe - $Acredor) ;                                    
    }

     public function getEstadoDeCuentaSaldoDolaresAttribute()
    {
        

        $Debe    = $this->movimientos_estado_de_cuenta_empresa->where('tipo_saldo','deudor')
                                                ->where('moneda','U$S')                                                
                                                ->sum('valor');

        $Acredor = $this->movimientos_estado_de_cuenta_empresa->where('tipo_saldo','acredor')                                  
                                                ->where('moneda','U$S')
                                                ->where('borrado','no')
                                                ->sum('valor');


        return round($Debe - $Acredor) ;                                    
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