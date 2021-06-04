<?php

namespace App\Repositorios;

use App\Entidades\AvisoEmpresa;

class AvisoEmpresaRepo extends BaseRepo
{
    public function getEntidad()
    {
        return new AvisoEmpresa();
    }

}
