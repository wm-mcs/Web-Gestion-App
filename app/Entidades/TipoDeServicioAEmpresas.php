<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;

class TipoDeServicioAEmpresas extends Model
{

    protected $table = 'tipos_de_servicios_a_empresas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description'];

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

}
