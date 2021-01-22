<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Entidades\User;
use Illuminate\Support\Facades\Cache;





class MovimientoEstadoDeCuentaSocio extends Model
{

    protected $table ='movimientos_estado_de_cuenta_socios';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    protected $appends  = ['fecha_formateada','fecha','user_name'];




    public function user()
    {
      return $this->belongsTo(User::class,'user_id','id');
    }

        public function getUserNameAttribute()
        {
            return  Cache::remember('UserMovimientoContableName'.$this->id, 100000, function() {
                              return $this->user->first_name;
                    }); 
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

    public function getFechaFormateadaAttribute()
    {
        

        return Carbon::parse($this->fecha_ingreso)->format('Y-m-d');
    }


    public function getFechaAttribute()
    {
        return Carbon::parse($this->fecha_ingreso)->format('Y-m-d');
    } 



    
    
}