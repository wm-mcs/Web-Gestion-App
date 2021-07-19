<?php

namespace App\Entidades;

use App\Repositorios\SucursalEmpresaRepo;
use App\Repositorios\TipoDeServicioRepo;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class ServicioContratadoSocio extends Model
{

    protected $table = 'servicios_contratados_socios';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description'];
    protected $appends  = [
        'fecha_vencimiento_formateada',
        'fecha_contratado_formateada',
        'fecha_consumido_formateada',
        'fecha_editada_formateada',
        'esta_vencido',
        'se_consumio',
        'sucursal_donde_se_emitio',
        'sucursal_donde_se_uso',
        'tipo_de_servicio',
    ];

    public function getSucursalDondeSeEmitioAttribute()
    {
        return Cache::remember('EmitioSucursalDondeSeEmitio' . $this->id, 1200, function () {
            $Repo     = new SucursalEmpresaRepo();
            $Sucursal = $Repo->find($this->sucursal_emitio_id);

            return $Sucursal;
        });
    }

    public function getTipoDeServicioAttribute()
    {
        return Cache::remember('tipoServicio' . $this->id, 30, function () {

            $Repo = new TipoDeServicioRepo();

            return $Repo->find($this->tipo_servicio_id);
        });
    }

    public function getSucursalDondeSeUsoAttribute()
    {
        if ($this->sucursal_uso_id == null) {
            return "";
        }

        return Cache::remember('SucursalDondeSeUso' . $this->id, 600, function () {
            $Repo     = new SucursalEmpresaRepo();
            $Sucursal = $Repo->find($this->sucursal_uso_id);
            return $Sucursal;
        });
    }

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

    public function getFechaVencimientoFormateadaAttribute()
    {
        return Carbon::parse($this->fecha_vencimiento)->format('Y-m-d');
    }

    public function getFechaConsumidoFormateadaAttribute()
    {
        return Carbon::parse($this->fecha_consumido)->format('Y-m-d');
    }

    public function getFechaContratadoFormateadaAttribute()
    {
        return $this->created_at->format('Y-m-d');
    }

    public function getFechaEditadaFormateadaAttribute()
    {
        return Carbon::parse($this->editado_at)->format('Y-m-d');
    }

    public function getEstaVencidoAttribute()
    {

        if (Carbon::now('America/Montevideo') >= Carbon::parse($this->fecha_vencimiento)) {
            return true;
        } else {
            return false;
        }

    }

    public function getSeConsumioAttribute()
    {
        if ($this->esta_consumido == 'no') {
            return false;
        }

        if (Carbon::now('America/Montevideo') >= Carbon::parse($this->fecha_consumido)) {
            return true;
        } else {
            return false;
        }
    }

}
