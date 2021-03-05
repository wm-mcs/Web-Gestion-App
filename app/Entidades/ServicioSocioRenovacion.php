<?php

namespace App\Entidades;

use App\Repositorios\TipoDeServicioRepo;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class ServicioSocioRenovacion extends Model
{

    protected $table = 'servicios_renovaciones_socios';
    protected $fillable = ['name', 'description'];
    protected $appends = ['servicio_tipo', 'fecha_de_la_ultima_renovacion'];

    public function getServicioTipoAttribute()
    {
        return Cache::remember('TipoServicioDeServicioRenovacion' . $this->id, 400, function () {
            $Repo = new TipoDeServicioRepo();

            return $Repo->find($this->tipo_servicio_id);
        });
    }

    public function getFechaDeLaUltimaRenovacionAttribute()
    {
        return Carbon::parse($this->fecha_ultima_renovacion)->format('Y-m-d');
    }

}
