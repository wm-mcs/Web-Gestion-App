<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use App\Entidades\EmpresaConSocios;
use Illuminate\Support\Facades\Auth;
use App\Repositorios\UserEmpresaRepo;






class SucursalEmpresa extends Model
{

    protected $table ='sucursales_empresa';

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
    
    
}