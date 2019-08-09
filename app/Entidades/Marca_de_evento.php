<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;
use App\Entidades\Marca;
use App\Entidades\Evento;




class Marca_de_evento extends Model
{

    protected $table ='marcas_de_eventos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description'];




    public function marca()
    {
      return $this->belongsTo(Marca::class,'marca_id','id');
    }

    public function evento()
    {
      return $this->belongsTo(Evento::class,'evento_id','id');
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
  
    
}