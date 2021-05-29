<?php

namespace App\Http\Controllers\Admin_Empresa;

use App\Helpers\HelperFechas;
use App\Helpers\HelpersGenerales;
use App\Http\Controllers\Controller;
use App\Repositorios\ActividadRepo;
use App\Repositorios\AgendaRepo;
use App\Repositorios\EmpresaConSociosoRepo;
use App\Repositorios\ReservaRepo;
use App\Repositorios\ServicioContratadoSocioRepo;
use App\Repositorios\SucursalEmpresaRepo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ReservaController extends Controller
{
    protected $EmpresaConSociosoRepo;

    public function __construct(EmpresaConSociosoRepo $EmpresaConSociosoRep
    ) {
        $this->EmpresaConSociosoRepo = $EmpresaConSociosoRep;
    }

    public function get_panel_de_reservas()
    {
        $Empresa = Session::get('empresa_auth_public');
        $Socio   = Session::get('socio-auth');

        $Data = [
            'title'       => 'Panel de reserva de ' . $Empresa->name,
            'img'         => $Empresa->url_img,
            'description' => '',
        ];

        return view('empresa_gestion_paginas.Vue_logica.Componentes.EmpresaReservasYPanelSocioPublico.panel_de_reserva_publico', compact('Empresa', 'Data'));
    }

    /**
     * Este método me devulve las sucursales de esta empresa asociadas a la empresa del socio
     */
    public function get_sucursales_public()
    {
        $Empresa = Session::get('empresa_auth_public');
        $Socio   = Session::get('socio-auth');

        $Repo = new SucursalEmpresaRepo();

        return HelpersGenerales::formateResponseToVue(true, 'Sucursales cargadas', $Repo->getSucursalesDeEmpresa($Empresa->id));
    }

    public function get_actividad_desde_reserva()
    {
        $Empresa = Session::get('empresa_auth_public');

        $Repo = new ActividadRepo();

        return HelpersGenerales::formateResponseToVue(true, 'Sucursales cargadas', $Repo->getEntidadesDeEstaEmpresa($Empresa->id, 'name', 'desc', false, 'no'));
    }

    public function get_clases_para_reservar_public(Request $Request)
    {
        $Empresa     = Session::get('empresa_auth_public');
        $Socio       = Session::get('socio-auth');
        $Sucursal_id = $Request->get('sucursal_id');

        $RepoAgenda  = new AgendaRepo();
        $ReservaRepo = new ReservaRepo();

        $ClasesParaREservarOrdenadasSegunDia = $RepoAgenda->getAgendasDeEstaSucursal($Empresa->id, $Sucursal_id, 'hora_inicio', 'asc');

        //¿Cuántos días le muestro?
        $Dias_por_adelantado_a_mostrar = $Empresa->reserva_de_clase_dias_por_adelantado;

        //Data
        $Data = [];

        $Contador = 0;

        while ($Contador < (int) $Dias_por_adelantado_a_mostrar) {
            $Dia = $Contador == 0 ? Carbon::now($Empresa->zona_horaria) : Carbon::now($Empresa->zona_horaria)->addDay($Contador)->startOfDay();

            $Clases_de_hoy = $ClasesParaREservarOrdenadasSegunDia->filter(function ($value) use ($Dia) {

                $validation = in_array((string) $Dia->dayOfWeekIso, explode(',', $value->days)) && (int) $Dia->hour <= intval(explode(':', $value->hora_inicio)[0]);

                return $validation;
            })->values();

            if (count($Clases_de_hoy) > 0) {
                foreach ($Clases_de_hoy as $Clase) {
                    $Clase->reservas_del_dia      = $ReservaRepo->getReservasDeEstaClaseDeEsteDia($Clase, $Dia)->count();
                    $Clase->auth_socio_ya_reservo = $ReservaRepo->verificarSiSocioYaReservo($Clase, $Dia, $Socio);
                }

                $Objeto           = new \stdClass();
                $Objeto->day      = $Dia;
                $Objeto->day_text = HelperFechas::getNombreDeDia($Dia->dayOfWeekIso) . ' ' . $Dia->format('d-m');
                $Objeto->clases   = $Clases_de_hoy;
                array_push($Data, $Objeto);
            } else {
            }

            $Contador += 1;
        }

        return HelpersGenerales::formateResponseToVue(true, 'Se cargaron los días para la reserva', $Data);
    }

    /**
     * Lógica de cuando se apreta el boton RESERVAR
     */
    public function efectuar_reserva(Request $Request)
    {

        $Empresa                       = Session::get('empresa_auth_public');
        $Socio                         = Session::get('socio-auth');
        $Sucursal_id                   = $Request->get('sucursal_id');
        $Agenda_id                     = $Request->get('agenda_id');
        $Actividad_id                  = $Request->get('actividad_id');
        $Fecha_de_cuando_sera_la_clase = $Request->get('fecha_de_cuando_sera_la_clase');

        $RepoAgenda  = new AgendaRepo();
        $ReservaRepo = new ReservaRepo();

        //Verificar si el socio cumple para reservar

        //Está al día
        if ($Empresa->reserva_de_clase_acepta_deuda == 'no') {
            if ($Socio->saldo_de_estado_de_cuenta_pesos < 0) {
                return HelpersGenerales::formateResponseToVue(false, 'Actualmente estás debiendo $ ' . $Socio->saldo_de_estado_de_cuenta_pesos . ' Para poder hacer reserva es necesario estar al día. Comunicate al ' . $Empresa->celular . ' o pasá por el local para liquidar esa deuda. ¡Saludos!');
            }
        }

        //Tiene algo contratado
        if ($Empresa->reserva_de_clase_acepta_sin_plan != 'si') {
            $ServicioContratadoSocioRepo = new ServicioContratadoSocioRepo();
            $ServiciosDisponibles        = $ServicioContratadoSocioRepo->getServiciosContratadosDisponiblesTodos($Socio->id);

            if ($ServiciosDisponibles->count() < 1) {
                return HelpersGenerales::formateResponseToVue(false, 'Tu servicio contrato está vencido. Comunicate al ' . $Empresa->celular . ' o pasá por el local para renovarlo. ¡Saludos!');
            } else {
                foreach ($ServiciosDisponibles as $Plan) {
                    if ($Plan->tipo_de_servicio->todo_las_clases_actividades_habilitadas != 'si') {
                        //Eso contratado le sirve para esta clase
                        if (!in_array((string) $Actividad_id, explode(',', $Plan->actividad_habilitadas))) {
                            return HelpersGenerales::formateResponseToVue(false, 'El plan que tenés no incluye esta actividad. Comunicate al ' . $Empresa->celular . ' o pasá por el local para ajustar el plan. ¡Saludos!');
                        }
                    }
                }
            }
        }

        $Agenda = $RepoAgenda->find($Agenda_id);

        //La clase tiene cupos
        if ($Agenda->tiene_limite_de_cupos != 'no') {
            //En caso de que si ¿Quedán disponibles?
            $Cantidad_de_registrados = $ReservaRepo->getReservasDeEstaClaseDeEsteDia($Agenda, Carbon::parse($Fecha_de_cuando_sera_la_clase))->count();

            if ($Cantidad_de_registrados + 1 > $Agenda->cantidad_de_cupos) {
                return HelpersGenerales::formateResponseToVue(false, 'Te ganaron de mano, en este momento alguien le dió al botón reservar más rapido y se quedó con el lugar. Intentá reservar en otro horario.');
            }
        }

        // ¿Ya hizo una reserva previamente?
        if ($ReservaRepo->verificarSiSocioYaReservo($Agenda, Carbon::parse($Fecha_de_cuando_sera_la_clase), $Socio)) {
            return HelpersGenerales::formateResponseToVue(true, 'Tu reserva quedó hecha. Te esperamos el ' . Carbon::parse($Fecha_de_cuando_sera_la_clase)->format('d-m') . ' a las ' . $Agenda->hora_inicio . ' hs.');
        } else {
            $ReservaRepo->setReserva($Empresa->id, $Sucursal_id, $Agenda->id, Carbon::parse($Fecha_de_cuando_sera_la_clase), $Socio->id, $Socio->name);

            //Enviar_email

            return HelpersGenerales::formateResponseToVue(true, 'Tu reserva quedó hecha. Te esperamos el ' . Carbon::parse($Fecha_de_cuando_sera_la_clase)->format('d-m') . ' a las ' . $Agenda->hora_inicio . ' hs.');
        }
    }

    public function eliminar_reserva(Request $Request)
    {
        $Empresa                       = Session::get('empresa_auth_public');
        $Socio                         = Session::get('socio-auth');
        $Sucursal_id                   = $Request->get('sucursal_id');
        $Agenda_id                     = $Request->get('agenda_id');
        $Actividad_id                  = $Request->get('actividad_id');
        $Fecha_de_cuando_sera_la_clase = Carbon::parse($Request->get('fecha_de_cuando_sera_la_clase'));

        $RepoAgenda  = new AgendaRepo();
        $ReservaRepo = new ReservaRepo();

        $Agenda = $RepoAgenda->find($Agenda_id);

        $Reservas = $ReservaRepo->getReservasDelDiaDelSocio($Agenda, $Fecha_de_cuando_sera_la_clase, $Socio);

        if ($Reservas->count() > 0) {
            foreach ($Reservas as $Reserva) {
                $ReservaRepo->destruir_esta_entidad($Reserva);
            }

            return HelpersGenerales::formateResponseToVue(true, 'Se borró la reserva correctamente');
        }

        return HelpersGenerales::formateResponseToVue(false, 'No se encontró la reserva a borrar');
    }
}
