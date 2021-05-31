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

        return $this->getEntidad()
            ->where('empresa_id', $Empresa_id)
            ->where('sucursal_id', $Sucursal_id)
            ->where('borrado', 'no')
            ->where(function ($q) use ($Estado) {

                if ($Estado == 'si') {
                    $q->where('estado', 'si');
                } else {
                    $q->where('estado', '<>', '');
                }
            })
            ->orderBy($Ordenar_key, $Order_sentido)
            ->get();
    }

    /**
     * Me devuelve las clases disponibles para reservar teniendo en cuenta:
     * La hora, el día y los días que la empresa quiera permitir hacer reservas.
     *
     *   */
    public function getClasesParaReservar()
    {

    }

    public function getAgendasDeEsteDia($Empresa_id, $Sucursal_id, $Dia)
    {
        return $this->getEntidad()
            ->where('empresa_id', $Empresa_id)
            ->where('sucursal_id', $Sucursal_id)
            ->where('borrado', 'no')
            ->where('estado', 'si')
            ->where('days', "LIKE", "%$Dia->dayOfWeekIso%")
            ->orderBy('hora_inicio', 'asc')
            ->get();
    }
}
