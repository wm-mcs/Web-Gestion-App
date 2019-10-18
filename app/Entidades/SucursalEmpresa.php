<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use App\Entidades\EmpresaConSocios;
use Illuminate\Support\Facades\Auth;
use App\Repositorios\UserEmpresaRepo;
use App\Repositorios\CajaEmpresaRepo;
use App\Entidades\CajaEmpresa;






class SucursalEmpresa extends Model
{

    protected $table ='sucursales_empresa';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description'];
    protected $appends  = ['movimientos_de_caja','saldo_de_caja_pesos','saldo_de_caja_dolares'];
    

 

    public function movimientos_de_caja_relation()
    {
        return $this->hasMany(CajaEmpresa::class,'sucursal_id','id')
                    ->where('borrado','no')
                    ->orderBy('created_at', 'DESC');
    }

      public function getMovimientosDeCajaAttribute()
      {
        return $this->movimientos_de_caja_relation;
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





   

    public function getPuedeVerElUserAttribute()
    {
        $User      = Auth::user();
        $Gerarquia = $User->role;

        if($Gerarquia > 2)
        {
            return true;
        }
        else
        {
            $Repo        = new UserEmpresaRepo();
            $UserEmpresa = $Repo->find($this->id);

            if($UserEmpresa->user_id == $User->id)
            {
                return true;
            }
            else
            {
                return false;
            }


        }
    }


    public function getSaldoDeCajaPesosAttribute()
    {

        if($this->estado_de_cuenta_socio->count() == 0)
        {
            return 0;
        }

        $EstadosRepo = new CajaEmpresaRepo();

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

    public function getSaldoDeCajaDolaresAttribute()
    {

        if($this->estado_de_cuenta_socio->count() == 0)
        {
            return 0;
        }
        $EstadosRepo = new CajaEmpresaRepo();

        $Debe    = $this->movimientos_de_caja->where('tipo_saldo','deudor')
                                                ->where('borrado','no')
                                                ->where('moneda','U$S')                                                
                                                ->sum('valor');

        $Acredor = $this->movimientos_de_caja->where('tipo_saldo','acredor')                                  
                                                ->where('moneda','U$S')
                                                ->where('borrado','no')
                                                ->sum('valor');


        return round($Debe - $Acredor) ;                                    
    }
    
    
}