<?php

namespace App\Entidades;

use App\Repositorios\SocioRepo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Reserva extends Model
{
    protected $table    = 'reservas';
    protected $fillable = ['name', 'description'];
    protected $appends  = ['socio'];

    public function getSocioAttribute()
    {
        return Cache::remember('reservaSocio' . $this->id, 2500000, function () {
            $Repo = new SocioRepo();
            return $Repo->find($this->socio_id);
        });
    }
}
