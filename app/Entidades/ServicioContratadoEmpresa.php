<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use App\Entidades\TipoDeServicioAEmpresas;





class ServicioContratadoEmpresa extends Model
{

    protected $table ='servicios_contratados_empresa';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    protected $appends  = [
                           'fecha_vencimiento_formateada',
                           'fecha_contratado_formateada',                           
                           'tipo_de_servicio'
                          ];



    public function tipo_servicio()
    {
      return  $this->belongsTo(TipoDeServicioAEmpresas::class,'tipo_servicio_id','id'); 
    }    

      public function getTipoDeServicioAttribute()
      {
          return Cache::remember('tipoServicioEmpresa'.$this->id, 300, function() {
                              return $this->tipo_servicio; 
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

     public function getFechaVencimientoFormateadaAttribute()
    {
        return Carbon::parse($this->fecha_vencimiento)->format('Y-m-d');
    }
public function getFechaContratadoFormateadaAttribute()
    {
        return $this->created_at->format('Y-m-d'); 
    }



    
    
}