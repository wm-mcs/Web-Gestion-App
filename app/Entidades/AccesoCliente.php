<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;
use App\Repositorios\SocioRepo;
use Illuminate\Support\Facades\Cache;




class AccesoCliente extends Model
{

    protected $table ='AccesosClientes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable  = ['name', 'description'];
    protected $appends   = ['socio','fecha_formateada'];

    
    

    public function getSocioAttribute()
    {
        return Cache::remember('SocioAccesosClientes'.$this->id, 100000, function() {
                        $Repo = new SocioRepo();
                        return $Repo->getEntidad()->find($this->socio_id);
                       });   
    }


    public function getFechaFormateadaAttribute()
    {
        return Carbon::parse($this->fecha)->format('Y-m-d-H-M');
    }
    
    
}