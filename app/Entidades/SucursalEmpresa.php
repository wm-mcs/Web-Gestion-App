<?php

namespace App\Entidades;

use App\Entidades\CajaEmpresa;
use App\Repositorios\CajaEmpresaRepo;
use App\Repositorios\UserEmpresaRepo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class SucursalEmpresa extends Model
{

    protected $table = 'sucursales_empresa';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description'];
    protected $appends = ['saldo_de_caja_pesos', 'saldo_de_caja_dolares', 'puede_ver_el_user'];

    public function movimientos_de_caja_relation()
    {
        return $this->hasMany(CajaEmpresa::class, 'sucursal_id', 'id')
            ->where('borrado', 'no')
            ->orderBy('created_at', 'DESC');
    }

    public function getMovimientosDeCajaAttribute()
    {
        return Cache::remember('MovimientosCajaSucursal' . $this->id, 120, function () {
            return $this->movimientos_de_caja_relation;
        });

    }

    public function getMovimientosDeCajaDolaresAttribute()
    {
        return Cache::remember('MovimientosCajaDolaresSucursal' . $this->id, 120, function () {
            return $this->movimientos_de_caja_relation
                ->where('moneda', 'U$S');
        });
    }

    public function getMovimientosDeCajaPesosAttribute()
    {
        return Cache::remember('MovimientosCajaPesosSucursal' . $this->id, 120, function () {
            return $this->movimientos_de_caja_relation
                ->where('moneda', '$');
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

    public function getPuedeVerElUserAttribute()
    {

        $User = Auth::user();
        $Gerarquia = $User->role;

        if ($Gerarquia > 2) {
            return true;
        } else {
            $Repo = new UserEmpresaRepo();
            $UserEmpresa = $Repo->getEntidad()->where('sucursal_id', $this->id)->get();

            if ($UserEmpresa->count() == 0) {
                return false;
            }

            $array = [];
            foreach ($UserEmpresa as $Usuario) {
                if ($Usuario->user_id == $User->id) {
                    array_push($array, 'true');
                } else {
                    array_push($array, 'false');
                }
            }

            if (in_array('true', $array)) {
                return true;
            } else {
                return false;
            }

        }
    }

    public function getSaldoDeCajaPesosAttribute()
    {

        return Cache::remember('SaldoCajaPesosSucursal' . $this->id, 120, function () {
            if ($this->movimientos_de_caja->count() == 0) {
                return 0;
            }

            $EstadosRepo = new CajaEmpresaRepo();

            $Debe = $this->movimientos_de_caja_pesos->where('tipo_saldo', 'deudor')
                ->sum('valor');

            $Acredor = $this->movimientos_de_caja_pesos->where('tipo_saldo', 'acredor')
                ->sum('valor');

            return round($Debe - $Acredor);
        });

    }

    public function getSaldoDeCajaDolaresAttribute()
    {

        return Cache::remember('SaldoCajaDolaresSucursal' . $this->id, 120, function () {
            if ($this->movimientos_de_caja->count() == 0) {
                return 0;
            }
            $EstadosRepo = new CajaEmpresaRepo();

            $Debe = $this->movimientos_de_caja_dolares->where('tipo_saldo', 'deudor')
                ->sum('valor');

            $Acredor = $this->movimientos_de_caja_dolares->where('tipo_saldo', 'acredor')
                ->sum('valor');

            return round($Debe - $Acredor);
        });

    }

}
