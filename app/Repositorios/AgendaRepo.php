<?php

namespace App\Repositorios;

use App\Entidades\Agenda;

class AgendaRepo extends BaseRepo
{
    public function getEntidad()
    {
        return new Agenda();
    }

    public function getAgendasDeEstaSucursal(
        $Empresa_id,
        $Sucursal_id,
        $Ordenar_key = 'id',
        $Order_sentido = 'desc',
        $Estado = 'si'

    ) {

        return $this->entidad
            ->where('empresa_id', $Empresa_id)
            ->where('sucursal_id', $Sucursal_id)
            ->where('borrado', 'no')
            ->where(function ($q) use ($Estado) {
                if ($Estado == 'si') {
                    $q->where('estado', 'si');
                }
            })
            ->orderBy($Ordenar_key, $Order_sentido)
            ->get();
    }
}
