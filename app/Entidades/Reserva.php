<?php

namespace App\Entidades;

use App\Repositorios\AgendaRepo;
use App\Repositorios\SocioRepo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Reserva extends Model
{
    protected $table    = 'reservas';
    protected $fillable = ['name', 'description'];
    protected $appends  = ['socio', 'agenda'];

    public function getSocioAttribute()
    {
        return Cache::remember('reservaSocio' . $this->id, 2500000, function () {
            $Repo = new SocioRepo();
            return $Repo->find($this->socio_id);
        });
    }

    public function getAgendaAttribute()
    {
        return Cache::remember('reservaAgenda' . $this->id, 2500000, function () {
            $Repo = new AgendaRepo();
            return $Repo->find($this->agenda_id);
        });
    }
}
