<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use App\Entidades\User;
use Carbon\Carbon;
use App\Entidades\Traits\entidadesScopesComunes;




class CajaEmpresa extends Model
{

    use entidadesScopesComunes;

    protected $table    ='caja_empresas';    
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

    public function getRouteAttribute()
    {
        /*return route('',[$this->helper_convertir_cadena_para_url($this->name), $this->id]);*/
    }
    
}