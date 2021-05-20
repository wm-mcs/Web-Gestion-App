<?php

namespace App\Repositorios;

use App\Entidades\Grupo;

class GrupoRepo extends BaseRepo
{
    public function getEntidad()
    {
        return new Grupo();
    }

    public function getGrupos($Empresa_id, $Sucursal_id)
    {
        return $this->getEntidad()
            ->where('borrado', 'no')
            ->where('empresa_id', $Empresa_id)
            ->where('sucursal_id', $Sucursal_id)
            ->get();
    }

}
