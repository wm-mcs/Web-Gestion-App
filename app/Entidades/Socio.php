<?php

namespace App\Entidades;

use App\Entidades\MovimientoEstadoDeCuentaSocio;
use App\Entidades\ServicioSocioRenovacion;
use App\Repositorios\ServicioContratadoSocioRepo;
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
        'fecha_creado_formateada',
        'url_img',
        'url_img_chica'];

    public function getServiciosContratadosDelSocioAttribute()
    {
        return Cache::remember('ServiciosContratadosDelSocio' . $this->id, 120, function () {

            $Repo = new ServicioContratadoSocioRepo();

            return $Repo->getServiciosContratadosASocios($this->id);
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

    public function getServiciosContratadosDisponiblesTipoClaseAttribute()
    {
        return Cache::remember('ServiciosContratadosDisponiblesTipoClaseSocio' . $this->id, 200, function () {

            $Repo = new ServicioContratadoSocioRepo();
            return $Repo->getServiciosContratadosDisponiblesTipoClase($this->id);
        });
    }

    public function getServiciosContratadosDisponiblesTipoMensualAttribute()
    {
        return Cache::remember('ServiciosContratadosDisponiblesTipoMensualSocio' . $this->id, 200, function () {
            $Repo = new ServicioContratadoSocioRepo();
            return $Repo->getServiciosContratadosDisponiblesTipoMensual($this->id);
        });
    }

    public function getPathImagenAttribute()
    {
        return public_path() . '/imagenes/Socios/' . $this->img . '.jpg';
    }

    public function getUrlImgAttribute()
    {

        if (file_exists($this->path_imagen)) {
            return url() . '/imagenes/Socios/' . $this->img . '.jpg';
        } else {
            return url() . '/imagenes/Socios/socio-icono.jpg';
        }

    }

    public function getPathImagenChicaAttribute()
    {
        return public_path() . '/imagenes/Socios/' . $this->img . '-chica.jpg';
    }

    public function getUrlImgChicaAttribute()
    {
        if (file_exists($this->path_imagen_chica)) {
            return url() . '/imagenes/Socios/' . $this->img . '.-chica.jpg';
        } else {
            return url() . '/imagenes/Socios/socio-icono.jpg';
        }

    }

    /**
     * PAra busqueda por nombre
     */
    public function scopeName($query, $name)
    {
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
