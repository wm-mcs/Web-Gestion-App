<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;

class TipoDeServicio extends Model
{

    protected $table = 'tipos_de_servicios';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description'];
    protected $appends  = ['es_clase'];

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

    public function getEsClaseAttribute()
    {
        if ($this->tipo == 'clase') {
            return true;
        } else {
            return false;
        }
    }

}
