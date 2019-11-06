<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;
use App\Entidades\TipoDeServicio;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;




class ServicioSocioRenovacion extends Model
{

    protected $table ='servicios_renovaciones_socios';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description'];
    protected $appends  = ['servicio_tipo','fecha_de_la_ultima_renovacion'];

    
    public function tipo_servicio()
    {
      return $this->belongsTo(TipoDeServicio::class,'tipo_servicio_id','id');
    }

      public function getServicioTipoAttribute()
      {
        return Cache::remember('TipoServicioDeServicioRenovacion'.$this->id, 400, function() {
                              return $this->tipo_servicio; 
                          }); 
      }


    public function getFechaDeLaUltimaRenovacionAttribute()
    {
        return Carbon::parse($this->fecha_ultima_renovacion)->format('Y-m-d');
    } 
    
}