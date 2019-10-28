<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;
use App\Entidades\Marca_de_evento;
use App\Entidades\Producto;
use Illuminate\Support\Facades\Cache;
use App\Entidades\User;
use Carbon\Carbon;




class CajaEmpresa extends Model
{

    protected $table ='caja_empresas';

    
    protected $fillable = ['name', 'description'];
    protected $hidden   = ['user'];
    protected $appends  = ['user_name','fecha'];



    public function user()
    {
      return $this->belongsTo(User::class,'user_id','id');
    }

        public function getUserNameAttribute()
        {
            return  Cache::remember('UserCajaName'.$this->id, 100000, function() {
                              return $this->user->first_name;
                          }); 
        }     


     
    public function getFechaAttribute()
    {
        return Carbon::parse($this->fecha_ingreso)->format('Y-m-d');
    } 
    
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