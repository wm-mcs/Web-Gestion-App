<?php

namespace App\Entidades;

use App\Repositorios\ActividadRepo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Agenda extends Model
{
    protected $table    = 'agendas';
    protected $fillable = ['name', 'description'];
    protected $appends  = ['actividad'];

    public function getActividadAttribute()
    {
        return Cache::remember('ActividadAgenda' . $this->id, 4000, function () {

            $Repo = new ActividadRepo();

            return $Repo->find($this->actividad_id);
        });
    }
}
