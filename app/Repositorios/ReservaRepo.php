<?php

namespace App\Repositorios;

use App\Entidades\Reserva;

class ReservaRepo extends BaseRepo
{
    public function getEntidad()
    {
        return new Reserva();
    }

    public function getReservasDeEstaClaseDeEsteDia($Clase, $Hoy)
    {
        return $this->getEntidad()
            ->where('empresa_id', $Clase->empresa_id)
            ->where('sucursal_id', $Clase->sucursal_id)
            ->whereBetween('fecha_que_se_efectura_la_clase', [$Hoy->startOfDay(), $Hoy->endOfDay()])
            ->where('agenda_id', $Clase->id)
            ->get();

    }

    /**
     * Crea la reserva
     *
     * @return Object Reserva
     */
    public function setReserva($Empresa_id, $Sucursal_id, $Agenda_id, $Fecha_que_se_efectura_la_clase, $Socio_id, $Nombre_de_socio)
    {
        $Entidad                                 = $this->getEntidad();
        $Entidad->estado                         = 'si';
        $Entidad->empresa_id                     = $Empresa_id;
        $Entidad->sucursal_id                    = $Sucursal_id;
        $Entidad->agenda_id                      = $Agenda_id;
        $Entidad->fecha_que_se_efectura_la_clase = $Fecha_que_se_efectura_la_clase;
        $Entidad->socio_id                       = $Socio_id;
        $Entidad->nombre_de_socio                = $Nombre_de_socio;
        $Entidad->save();

        return $Entidad;

    }

    /**
     * Verificá que el socio efectivamente este o no ya reservado
     *
     * @return bool
     */
    public function verificarSiSocioYaReservo($Clase, $Dia, $Socio)
    {

        $Entidades = $this->getEntidad()
            ->where('empresa_id', $Clase->empresa_id)
            ->where('sucursal_id', $Clase->sucursal_id)
            ->where('socio_id', $Socio->id)
            ->whereBetween('fecha_que_se_efectura_la_clase', [$Dia->startOfDay(), $Dia->endOfDay()])
            ->where('agenda_id', $Clase->id)
            ->get();

        return $Entidades->count() > 0 ? true : false;
    }

    public function getReservasDelDiaDelSocio($Clase, $Dia, $Socio)
    {
        return $this->getEntidad()
            ->where('empresa_id', $Clase->empresa_id)
            ->where('sucursal_id', $Clase->sucursal_id)
            ->where('socio_id', $Socio->id)
            ->whereBetween('fecha_que_se_efectura_la_clase', [$Dia->startOfDay(), $Dia->endOfDay()])
            ->where('agenda_id', $Clase->id)
            ->get();
    }
}
