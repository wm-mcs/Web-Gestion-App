<?php

namespace App\Entidades;

use App\Repositorios\UserEmpresaRepo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class SucursalEmpresa extends Model
{
    protected $table = 'sucursales_empresa';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description'];
    protected $appends  = ['puede_ver_el_user'];

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

    public function getPuedeVerElUserAttribute()
    {

        if (Auth::guest()) {
            return false;
        }

        $User      = Auth::user();
        $Gerarquia = $User->role;

        if ($Gerarquia > 2) {
            return true;
        } else {
            $Repo        = new UserEmpresaRepo();
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
}
