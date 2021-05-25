<?php

namespace App\Http\Controllers\Admin_Empresa;

use App\Helpers\HelpersGenerales;
use App\Http\Controllers\Controller;
use App\Repositorios\EmpresaConSociosoRepo;
use App\Repositorios\SucursalEmpresaRepo;
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

}
