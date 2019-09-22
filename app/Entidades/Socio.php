<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;
use App\Repositorios\MovimientoEstadoDeCuentaSocioRepo;
use App\Entidades\ServicioContratadoSocio;
use Illuminate\Support\Facades\Cache;





class Socio extends Model
{

    protected $table ='socios';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description'];



    protected $appends = ['route', 'estado_de_cuenta_socio','saldo_de_estado_de_cuenta_pesos','saldo_de_estado_de_cuenta_dolares'];


    public function servicios_contratados()
    {
      return $this->hasMany(ServicioContratadoSocio::class,'socio_id','id')->where('borrado','no')->orderBy('created_at', 'asc');
    }


    public function getServiciosContratadosDelSocioAttribute()
    {
        return $this->servicios_contratados; /*Cache::remember('tipoDeServicio'.$this->id, 2, function() {
                              return $this->servicios_contratados; 
                          }); */
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



    public function getRouteAttribute()
    {
        return route('get_socio_panel',$this->id);
    }


    public function getEstadoDeCuentaSocioAttribute()
    {
        $EstadosRepo = new MovimientoEstadoDeCuentaSocioRepo();

        return $EstadosRepo->getEstadoDeCuentasDelSocio($this->id);
    }
    

    public function getSaldoDeEstadoDeCuentaPesosAttribute()
    {
        $EstadosRepo = new MovimientoEstadoDeCuentaSocioRepo();

        $Debe    = $this->estado_de_cuenta_socio->where('tipo_saldo','deudor')
                                                ->where('borrado','no')
                                                ->where('moneda','$')                                                
                                                ->sum('valor');

        $Acredor = $this->estado_de_cuenta_socio->where('tipo_saldo','acredor') 
                                                ->where('borrado','no')                                 
                                                ->where('moneda','$')
                                                ->sum('valor');


        return round($Debe - $Acredor) ;                                    
    }

     public function getSaldoDeEstadoDeCuentaDolaresAttribute()
    {
        $EstadosRepo = new MovimientoEstadoDeCuentaSocioRepo();

        $Debe    = $this->estado_de_cuenta_socio->where('tipo_saldo','deudor')
                                                ->where('borrado','no')
                                                ->where('moneda','U$S')                                                
                                                ->sum('valor');

        $Acredor = $this->estado_de_cuenta_socio->where('tipo_saldo','acredor')                                  
                                                ->where('moneda','U$S')
                                                ->where('borrado','no')
                                                ->sum('valor');


        return round($Debe - $Acredor) ;                                    
    }



    
    
}