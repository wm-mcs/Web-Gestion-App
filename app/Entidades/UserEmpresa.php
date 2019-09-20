<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use App\Entidades\User;
use App\Entidades\EmpresaConSocios;





//Usuarios y empresas asociados
class UserEmpresa extends Model
{

    protected $table ='lista_usuarios_empresas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description'];
    /*protected $appends  = ['usuario','empresa_asociada'];*/


    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    } 

      public function getUsuarioAttribute()
      {

        return $this->user;
      }

    public function empresa()
    {
        return $this->belongsTo(EmpresaConSocios::class,'empresa_id','id');
    }  

      public function getEmpresaAsociadaAttribute()
      {

       
        return $this->empresa;
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
        /*return route('',[$this->helper_convertir_cadena_para_url($this->name), $this->id]);*/
    }
    
    
}