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
use App\Repositorios\ServicioEmpresaRenovacionRepo;
use App\Repositorios\ServicioContratadoEmpresaRepo;
use App\Repositorios\VendedorEmpresaRepo;
use App\Repositorios\UserRepo;





class EmpresaConSocios extends Model
{

    protected $table ='empresa_con_socios';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description'];
    protected $appends  = ['tipo_servicios',/*
                           'socios_de_la_empresa',*/
                           'sucursuales_empresa',
                           'url_img',
                           'route_admin',
                           'movimientos_estado_de_cuenta_empresa',
                           'estado_de_cuenta_saldo_pesos',
                           'estado_de_cuenta_saldo_dolares',
                           'servicios_de_renovacion_empresa',
                           'servicios_contratados_a_empresas_activos',
                           'servicios_contratados_a_empresas_desactivos',
                           'vendedor_de_esta_empresa'];


    public function servicios_relation()
    {
      return $this->hasMany(TipoDeServicio::class,'empresa_id','id')->where('borrado','no');
    }

        public function getTipoServiciosAttribute()
        {        
           return $this->servicios_relation;
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
          return Cache::remember('MovimeintosEstadoDeCuentaEmpresa'.$this->id, 8000, function() {


           return  $this->movimientos_estado_de_cuenta;
          });
      } 

      

    public function getEstadoDeCuentaSaldoPesosAttribute()
    {

        if($this->movimientos_estado_de_cuenta_empresa->count() == 0)
        {
          return 0;
        }
        return Cache::remember('SaldoPesosEmpresa'.$this->id, 8000, function() {

        $Debe    = $this->movimientos_estado_de_cuenta_empresa->where('tipo_saldo','deudor')
                                                              ->where('borrado','no')  
                                                              ->where('moneda','$')                         
                                                              ->sum('valor');

        $Acredor = $this->movimientos_estado_de_cuenta_empresa->where('tipo_saldo','acredor') 
                                                              ->where('borrado','no')       
                                                              ->where('moneda','$')
                                                              ->sum('valor');


        return round($Debe - $Acredor) ;    

      });                                
    }

    public function getEstadoDeCuentaSaldoDolaresAttribute()
    {

        if($this->movimientos_estado_de_cuenta_empresa->count() == 0)
        {
          return 0;
        }
        return Cache::remember('SaldoDoalresEmpresa'.$this->id, 8000, function() {

        $Debe    = $this->movimientos_estado_de_cuenta_empresa->where('tipo_saldo','deudor')
                                                              ->where('moneda','U$S')   
                                                              ->where('borrado','no')                    
                                                              ->sum('valor');

        $Acredor = $this->movimientos_estado_de_cuenta_empresa->where('tipo_saldo','acredor')
                                                              ->where('moneda','U$S')
                                                              ->where('borrado','no')
                                                              ->sum('valor');


        return round($Debe - $Acredor) ;   
       });                                  
    }


    public function getServiciosDeRenovacionEmpresaAttribute()
    {
         return Cache::remember('ServiciosDerenovacionEmpresa'.$this->id, 8000, function() {

         $Repo = new ServicioEmpresaRenovacionRepo();

         return $Repo->getServiciosDeRenovacionDeLaEmpresaActivos($this->id);
         });    
    } 



    public function getServiciosContratadosAEmpresasActivosAttribute()
    {

         return Cache::remember('ServiciosActivosEmpresa'.$this->id, 8000, function() {

         $Repo = new ServicioContratadoEmpresaRepo();

         return $Repo->getServiciosActivosDeEstaEmpresa($this->id);
         }); 

    }

    public function getServiciosContratadosAEmpresasDesactivosAttribute()
    {

         return Cache::remember('ServiciosDesactivosEmpresa'.$this->id, 8000, function() {

         $Repo = new ServicioContratadoEmpresaRepo();

         return $Repo->getServiciosDesactivosDeEstaEmpresa($this->id);
         }); 
    }



    public function getVendedorDeEstaEmpresaAttribute()
    {
        /*return Cache::remember('VendedorDeEstaEmpresa'.$this->id, 8000, function() {*/

         $VendedorRepo = new VendedorEmpresaRepo();
         $UserRepo     = new UserRepo(); 

         $VendedorId = $VendedorRepo->getVendedoresDeEstaEmpresa($this->id); 

         dd($VendedorId->first()->user_id);
         $VendedorId = $VendedorId->first()->user_id;

         return $UserRepo->find($VendedorId);
         /*}); */ 
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