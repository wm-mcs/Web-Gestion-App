<?php

namespace App\Http\Controllers\Admin_Empresa;

use App\Helpers\HelperFechas;
use App\Helpers\HelpersGenerales;
use App\Http\Controllers\Controller;
use App\Repositorios\ActividadRepo;
use App\Repositorios\AgendaRepo;
use App\Repositorios\EmpresaConSociosoRepo;
use App\Repositorios\ReservaRepo;
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
                    $Clase->reservas_del_dia = $ReservaRepo->getReservasDeEstaClaseDeEsteDia($Clase, $Dia)->count();
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
}
