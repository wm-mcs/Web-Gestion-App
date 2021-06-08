<?php

namespace App\Repositorios;

use App\Entidades\AvisoEmpresa;

class AvisoEmpresaRepo extends BaseRepo
{
    public function getEntidad()
    {
        return new AvisoEmpresa();
    }

    /**
     * @params $leidos valor diferente que quiro traer
     */
    public function getAvisosDeEmpresa($Empresa_id, $leidos = null)
    {
        return $this->getEntidad()
            ->where('borrado', 'no')
            ->where('empresa_id', $Empresa_id)
            ->where(function ($q) use ($Empresa_id, $leidos) {
                if ($leidos != null) {
                    $q->where('leido', '<>', 'si');
                }
            })
            ->orderBy('created_at', 'desc')
            ->get();
    }

}
