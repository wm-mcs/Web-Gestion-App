<?php

namespace App\Repositorios;

use App\Entidades\GrupoSocioRelacion;

class GrupoSocioRelacionRepo extends BaseRepo
{
    public function getEntidad()
    {
        return new GrupoSocioRelacion();
    }
}
