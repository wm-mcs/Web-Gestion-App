<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use App\Entidades\User;
use Carbon\Carbon;
use App\Entidades\Traits\entidadesScopesComunes;
use App\Entidades\TipoDeMovimiento;




class CajaEmpresa extends Model
{

    use entidadesScopesComunes;

    protected $table    = 'caja_empresas';    
    protected $fillable = ['name', 'description'];
    protected $hidden   = ['user'];
    protected $appends  = ['user_name','fecha','tipo_de_movimiento_cache'];
    

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

    public function tipo_de_movimiento()
    {
        return $this->hasOne(TipoDeMovimiento::class,'tipo_de_movimiento_id','id');
    } 

        public function getTipoDeMovimientoCacheAttribute()
        {
            return  Cache::remember('getTipoDeMovimientoCacheAttribute'.$this->id, 100000, function() {
                        return $this->tipo_de_movimiento;
                    }); 
        }  
    public function getFechaAttribute()
    {
        return Carbon::parse($this->fecha_ingreso)->format('Y-m-d');
    } 

    public function getRouteAttribute()
    {
        /*return route('',[$this->helper_convertir_cadena_para_url($this->name), $this->id]);*/
    }
    
}