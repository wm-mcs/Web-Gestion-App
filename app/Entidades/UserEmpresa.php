<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use App\Repositorios\UserRepo;
use App\Repositorios\EmpresaConSociosoRepo;



class UserEmpresa extends Model
{

    protected $table ='lista_usuarios_empresas';

    protected $appends  = ['usuario','empresa_asociada'];


   

      public function getUsuarioAttribute()
      {
        $Repo = new UserRepo();
        $User = $Repo->find($this->user_id);

        return $User;
      }

   

      public function getEmpresaAsociadaAttribute()
      {

        $Repo    = new EmpresaConSociosoRepo();
        $Empresa = $Repo->find($this->empresa_id);

        return $Empresa;
        
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

    
    
}