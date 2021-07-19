<?php

namespace App\Repositorios;

use App\Entidades\Reserva;
use Carbon\Carbon;

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
            ->whereBetween('fecha_que_se_efectura_la_clase', [$Hoy->copy()->startOfDay(), $Hoy->copy()->endOfDay()])
            ->where('agenda_id', $Clase->id)
            ->get();

    }

    public function getReservasDeEsteDiaDelSocio($Empresa_id, $Sucursal_id, $Socio, $Hoy)
    {
        return $this->getEntidad()
            ->where('empresa_id', $Empresa_id)
            ->where('sucursal_id', $Sucursal_id)
            ->whereBetween('fecha_que_se_efectura_la_clase', [$Hoy->copy()->startOfDay(), $Hoy->copy()->endOfDay()])
            ->where('socio_id', $Socio->id)
            ->get();
    }

    public function getReservasTodasDeEsteDia($Empresa_id, $Sucursal_id, $Hoy)
    {
        return $this->getEntidad()
            ->where('empresa_id', $Empresa_id)
            ->where('sucursal_id', $Sucursal_id)
            ->whereBetween('fecha_que_se_efectura_la_clase', [$Hoy->copy()->startOfDay(), $Hoy->copy()->endOfDay()])
            ->get();
    }

    /**
     * Crea la reserva
     *
     * @return Object Reserva
     */
    public function setReserva($Empresa_id, $Sucursal_id, $Agenda_id, $Fecha_que_se_efectura_la_clase, $Socio_id, $Nombre_de_socio, $FechaQueSeHaceLaReserva = null)
    {
        $Entidad                                 = $this->getEntidad();
        $Entidad->estado                         = 'si';
        $Entidad->empresa_id                     = $Empresa_id;
        $Entidad->sucursal_id                    = $Sucursal_id;
        $Entidad->agenda_id                      = $Agenda_id;
        $Entidad->fecha_que_se_efectura_la_clase = $Fecha_que_se_efectura_la_clase;
        $Entidad->socio_id                       = $Socio_id;
        $Entidad->nombre_de_socio                = $Nombre_de_socio;
        $Entidad->fecha_que_se_hizo_la_reserva   = $FechaQueSeHaceLaReserva == null ? Carbon::now() : $FechaQueSeHaceLaReserva;
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
            ->whereBetween('fecha_que_se_efectura_la_clase', [$Dia->copy()->startOfDay(), $Dia->copy()->endOfDay()])
            ->where('agenda_id', $Clase->id)
            ->get();

        return $Entidades->count() > 0 ? true : false;
    }

    /**
     * Las reservas del día del socio con respecto a una clase en particular
     */
    public function getReservasDelDiaDelSocio($Clase, $Dia, $Socio)
    {
        return $this->getEntidad()
            ->where('empresa_id', $Clase->empresa_id)
            ->where('sucursal_id', $Clase->sucursal_id)
            ->where('socio_id', $Socio->id)
            ->whereBetween('fecha_que_se_efectura_la_clase', [$Dia->copy()->startOfDay(), $Dia->copy()->endOfDay()])
            ->where('agenda_id', $Clase->id)
            ->get();
    }

    /**
     * Las reservas del día del socio en general que rondan según la hora que ingresa.
     */
    public function getReservasDelDiaDelSocioTodas($HoraActual, $Socio, $Empresa_id, $Sucursal_id)
    {
        return $this->getEntidad()
            ->where('empresa_id', $Empresa_id)
            ->where('sucursal_id', $Sucursal_id)
            ->where('socio_id', $Socio->id)
            ->whereBetween('fecha_que_se_efectura_la_clase', [$HoraActual->copy()->startOfHour()->subMinutes(5), $HoraActual->copy()->addHours(1)])
            ->get();
    }

    public function getReservasDeSocioHistoricas($Empresa_id, $Sucursal_id, $Socio_id)
    {
        return $this->getEntidad()
            ->where('empresa_id', $Empresa_id)
            ->where('sucursal_id', $Sucursal_id)
            ->where('socio_id', $Socio_id)
            ->orderBy('id', 'desc')
            ->get();
    }
}
