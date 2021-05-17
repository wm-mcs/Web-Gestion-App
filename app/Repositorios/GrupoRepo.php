<?php

namespace App\Repositorios;

use App\Entidades\Grupo;

class GrupoRepo extends BaseRepo
{
    public function getEntidad()
    {
        return new Grupo();
    }

}
