<?php

namespace App\Entidades;

use App\Entidades\MovimientoEstadoDeCuentaSocio;
use App\Entidades\ServicioContratadoSocio;
use App\Entidades\ServicioSocioRenovacion;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Socio extends Model
{

    protected $table = 'socios';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description'];

    protected $appends = ['estado_de_cuenta_socio',
        'saldo_de_estado_de_cuenta_pesos',
        'saldo_de_estado_de_cuenta_dolares',
        'servicios_contratados_del_socio',
        'servicios_contratados_disponibles_tipo_clase',
        'servicios_contratados_disponibles_tipo_mensual',
        'servicios_renovacion_del_socio',
        'fecha_creado_formateada'];

    public function servicios_contratados()
    {
        return $this->hasMany(ServicioContratadoSocio::class, 'socio_id', 'id')->where('borrado', 'no')
            ->orderBy('created_at', 'DESC');
    }

    public function getServiciosContratadosDelSocioAttribute()
    {
        return Cache::remember('ServiciosContratadosDelSocio' . $this->id, 120, function () {
            return $this->servicios_contratados;
        });
    }

    public function servicios_renovacion()
    {
        return $this->hasMany(ServicioSocioRenovacion::class, 'socio_id', 'id')->orderBy('created_at', 'DESC');
    }

    public function getServiciosRenovacionDelSocioAttribute()
    {
        return Cache::remember('servicioRenovacionSocio' . $this->id, 30, function () {
            return $this->servicios_renovacion;
        });
    }

    public function servicio_contratados_tipo_clases()
    {
        $Hoy = Carbon::now('America/Montevideo');

        $Servicos_tipo_clase = $this->hasMany(ServicioContratadoSocio::class, 'socio_id', 'id')
            ->where('borrado', 'no')
            ->where('tipo', 'clase')
            ->where('esta_consumido', 'no')
            ->where('fecha_vencimiento', '>', $Hoy)
            ->orderBy('created_at', 'DESC');

        return $Servicos_tipo_clase;
    }

    public function getServiciosContratadosDisponiblesTipoClaseAttribute()
    {
        return Cache::remember('ServiciosContratadosDisponiblesTipoClaseSocio' . $this->id, 200, function () {
            return $this->servicio_contratados_tipo_clases;
        });
    }

    public function servicio_contratados_tipo_mensual()
    {
        $Hoy = Carbon::now('America/Montevideo');

        $Servicos_tipo_mensual = $this->hasMany(ServicioContratadoSocio::class, 'socio_id', 'id')
            ->where('borrado', 'no')
            ->where('tipo', 'mensual')
            ->where('fecha_vencimiento', '>', $Hoy)
            ->orderBy('created_at', 'DESC');

        return $Servicos_tipo_mensual;
    }
    public function getServiciosContratadosDisponiblesTipoMensualAttribute()
    {
        return Cache::remember('ServiciosContratadosDisponiblesTipoMensualSocio' . $this->id, 200, function () {
            return $this->servicio_contratados_tipo_mensual;
        });
    }

    /**
     * PAra busqueda por nombre
     */
    public function scopeName($query, $name)
    {
        //si el paramatre(campo busqueda) esta vacio ejecutamos el codigo
        /// trim() se utiliza para eliminar los espacios.
        ////Like se usa para busqueda incompletas
        /////%% es para los espacios adelante y atras
        if (trim($name) != "") {
            $query->where('name', "LIKE", "%$name%");
        }

    }

    public function scopeActive($query)
    {

        $query->where('estado', "si");

    }

    public function scopeNoborrado($query)
    {

        $query->where('borrado', "no");

    }

    public function estados_de_cuenta_socio_relation()
    {
        return $this->hasMany(MovimientoEstadoDeCuentaSocio::class, 'socio_id', 'id')
            ->where('borrado', 'no')
            ->orderBy('fecha_ingreso', 'desc');
    }

    public function getEstadoDeCuentaSocioAttribute()
    {

        return Cache::remember('getEstadoDeCuentaSocio' . $this->id, 200, function () {
            return $this->estados_de_cuenta_socio_relation;
        });
    }

    public function getSaldoDeEstadoDeCuentaPesosAttribute()
    {

        return Cache::remember('SaldoPesosSocio' . $this->id, 200, function () {
            $Debe = $this->estado_de_cuenta_socio->where('tipo_saldo', 'deudor')
                ->where('moneda', '$')
                ->sum('valor');

            $Acredor = $this->estado_de_cuenta_socio->where('tipo_saldo', 'acredor')
                ->where('moneda', '$')
                ->sum('valor');
            return round($Debe - $Acredor);
        });

    }

    public function getSaldoDeEstadoDeCuentaDolaresAttribute()
    {
        return Cache::remember('SaldoDoalresSocio' . $this->id, 200, function () {
            $Debe = $this->estado_de_cuenta_socio->where('tipo_saldo', 'deudor')
                ->where('moneda', 'U$S')
                ->sum('valor');

            $Acredor = $this->estado_de_cuenta_socio->where('tipo_saldo', 'acredor')
                ->where('moneda', 'U$S')
                ->sum('valor');

            return round($Debe - $Acredor);
        });

    }

    public function getFechaCreadoFormateadaAttribute()
    {
        return $this->created_at->format('Y-m-d');
    }

}
