<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;





class MovimientoEstadoDeCuentaSocio extends Model
{

    protected $table ='movimientos_estado_de_cuenta_socios';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    protected $appends  = ['fecha_formateada'];




    

    


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



    
    
}