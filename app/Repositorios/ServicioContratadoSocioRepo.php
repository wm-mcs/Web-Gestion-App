<?php

namespace App\Repositorios;

use App\Entidades\ServicioContratadoSocio;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

/**
 * Repositorio de consultas a la base de datos User
 */
class ServicioContratadoSocioRepo extends BaseRepo
{
    public function getEntidad()
    {
        return new ServicioContratadoSocio();
    }

//guetters/////////////////////////////////////////////////////////////////////

    //setters//////////////////////////////////////////////////////////////////////

    public function getServiciosContratadosASocios($socio_id)
    {
        return $this->getEntidad()
            ->where('socio_id', $socio_id)
            ->where('estado', 'si')
            ->where('borrado', 'no')
            ->orderBy('fecha_vencimiento', 'desc')
            ->get();
    }

    public function getServiciosDeEsteSocioYConEsteTipoId($socio_id, $Tipo_id)
    {
        $servicios = $this->getEntidad()
            ->where('socio_id', $socio_id)
            ->where('estado', 'si')
            ->where('borrado', 'no')
            ->where('tipo_servicio_id', $Tipo_id)
            ->orderBy('fecha_vencimiento', 'desc')
            ->get();

        return $servicios->first();
    }

    public function setServicioASocio($Socio_id, $Scuursal_id, $Tipo_de_servicio_objeto, $Fecha_vencimiento)
    {
        $Entidad                     = $this->getEntidad();
        $Entidad->estado             = 'si';
        $Entidad->borrado            = 'no';
        $Entidad->esta_consumido     = 'no';
        $Entidad->sucursal_emitio_id = $Scuursal_id;
        $Entidad->socio_id           = $Socio_id;
        $Entidad->tipo_servicio_id   = $Tipo_de_servicio_objeto->id;
        $Entidad->empresa_id         = $Tipo_de_servicio_objeto->empresa_id;
        $Entidad->tipo               = $Tipo_de_servicio_objeto->tipo;
        $Entidad->name               = $Tipo_de_servicio_objeto->name;
        $Entidad->valor              = $Tipo_de_servicio_objeto->valor;
        $Entidad->moneda             = $Tipo_de_servicio_objeto->moneda;
        $Entidad->fecha_vencimiento  = $Fecha_vencimiento;
        $Entidad->save();

        $this->ActualizarCache($Socio_id);

        return $Entidad;
    }

    public function getServiciosContratadosDisponiblesTipoClase($socio_id)
    {
        $Hoy = Carbon::now('America/Montevideo');

        $Servicos_tipo_clase = $this->getEntidad()
            ->where('socio_id', $socio_id)
            ->where('borrado', 'no')
            ->where('tipo', 'clase')
            ->where('esta_consumido', 'no')
            ->where('fecha_vencimiento', '>', $Hoy)
            ->orderBy('created_at', 'DESC')
            ->get();

        return $Servicos_tipo_clase;
    }

    public function getServiciosContratadosDisponiblesTipoMensual($socio_id)
    {
        $Hoy = Carbon::now('America/Montevideo');

        $Servicos_tipo_mensual = $this->getEntidad()
            ->where('socio_id', $socio_id)
            ->where('borrado', 'no')
            ->where('tipo', 'mensual')
            ->where('fecha_vencimiento', '>', $Hoy)
            ->orderBy('created_at', 'DESC')
            ->get();

        return $Servicos_tipo_mensual;
    }

    public function getServiciosContratadosDelSocio($socio_id)
    {
        return $this->getEntidad()
            ->where('socio_id', $socio_id)
            ->where('borrado', 'no')
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    public function ActualizarCache($socio_id)
    {
        $Array_cache = [
            'ServiciosContratadosDisponiblesTipoClaseSocio' . $socio_id,
            'ServiciosContratadosDisponiblesTipoMensualSocio' . $socio_id,
            'ServiciosContratadosDelSocio' . $socio_id,
        ];

        foreach ($Array_cache as $cache) {
            if (Cache::has($cache)) {
                Cache::forget($cache);
            }
        }

        $Servicos_tipo_clase = $this->getServiciosContratadosDisponiblesTipoClase($socio_id);
        Cache::remember('ServiciosContratadosDisponiblesTipoClaseSocio' . $socio_id, 120, function () use ($Servicos_tipo_clase) {
            return $Servicos_tipo_clase;
        });

        $Servicos_tipo_mensual = $this->getServiciosContratadosDisponiblesTipoMensual($socio_id);
        Cache::remember('ServiciosContratadosDisponiblesTipoMensualSocio' . $socio_id, 120, function () use ($Servicos_tipo_mensual) {
            return $Servicos_tipo_mensual;
        });

        $Servicos = $this->getServiciosContratadosDelSocio($socio_id);
        Cache::remember('ServiciosContratadosDelSocio' . $socio_id, 120, function () use ($Servicos) {
            return $Servicos;
        });
    }
}
