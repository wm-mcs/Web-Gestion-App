<?php

namespace App\Http\Controllers\Admin_Empresa;

use App\Helpers\HelperFechas;
use App\Helpers\HelpersGenerales;
use App\Http\Controllers\Controller;
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

    public function get_clases_para_reservar_public(Request $Request)
    {
        $Empresa     = Session::get('empresa_auth_public');
        $Socio       = Session::get('socio-auth');
        $Sucursal_id = $Request->get('sucursal_id');

        $RepoAgenda  = new AgendaRepo();
        $ReservaRepo = new ReservaRepo();

        $Hoy = Carbon::now($Empresa->zona_horaria);

        $ClasesParaREservarOrdenadasSegunDia = $RepoAgenda->getAgendasDeEstaSucursal($Empresa->id, $Sucursal_id, 'hora_inicio', 'asc');

        //¿Qué día es hoy?
        $Hoy->dayOfWeekIso;

//0

        //¿Qué hora es?
        $Hoy->hour;

        //¿Cuántos días le muestro?
        $Dias_por_adelantado_a_mostrar = 2;

        //Data
        $Data = [];

        $Contador = 0;

        while ($Contador < $Dias_por_adelantado_a_mostrar) {
            $Clases_de_hoy = $ClasesParaREservarOrdenadasSegunDia->filter(function ($value) use ($Hoy) {

                return in_array($Hoy->dayOfWeekIso, explode(',', $value->days)) && (int) $Hoy->hour <= (int) explode(':', $value->hora_inicio)[0];
            })->all();

            if (count($Clases_de_hoy) > 0) {
                foreach ($Clases_de_hoy as $Clase) {
                    $Clase->reservas_del_dia = $ReservaRepo->getReservasDeEstaClaseDeEsteDia($Clase, $Hoy)->count();
                }

                $Objeto           = new \stdClass();
                $Objeto->day      = $Hoy;
                $Objeto->day_text = HelperFechas::getNombreDeDia($Hoy->dayOfWeekIso) . ' ' . $Hoy->format('d-m');
                $Objeto->clases   = $Clases_de_hoy;
                array_push($Data, $Objeto);
                $Contador += 1;
            }

            $Hoy->addDay()->startOfDay();
        }

        return HelpersGenerales::formateResponseToVue(true, 'Se cargaron los días para la reserva', $Data);
    }
}
