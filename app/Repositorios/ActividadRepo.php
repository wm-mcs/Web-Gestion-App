<?php

namespace App\Repositorios;

use App\Entidades\Actividad;

class ActividadRepo extends BaseRepo
{
    public function getEntidad()
    {
        return new Actividad();
    }

}
