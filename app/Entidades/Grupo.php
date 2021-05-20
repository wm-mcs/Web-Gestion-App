<?php

namespace App\Entidades;

use App\Repositorios\SucursalEmpresaRepo;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    protected $table    = 'grupos';
    protected $fillable = ['name', 'description'];
    protected $appends  = ['sucursal'];

    public function getSucursalAttribute()
    {
        $Repo = new SucursalEmpresaRepo();

        return $Repo->find($this->sucursal_id);
    }

}
