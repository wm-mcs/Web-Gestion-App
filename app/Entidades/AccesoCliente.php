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
    protected $appends   = ['socio'];

    
    

    public function getSocioAttribute()
    {
        return Cache::remember('SocioAccesosClientes'.$this->id, 100000, function() {
                        $Repo = new SocioRepo();
                        return $Repo->getEntidad()->find($this->socio_id);
                       });   
    }
    
    
}