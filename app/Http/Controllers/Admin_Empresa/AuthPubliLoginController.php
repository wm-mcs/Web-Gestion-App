<?php

namespace App\Http\Controllers\Admin_Empresa;

use App\Http\Controllers\Controller;
use App\Repositorios\EmpresaConSociosoRepo;
use App\Repositorios\SocioRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthPubliLoginController extends Controller
{
    protected $EmpresaConSociosoRepo;

    public function __construct(EmpresaConSociosoRepo $EmpresaConSociosoRep
    ) {
        $this->EmpresaConSociosoRepo = $EmpresaConSociosoRep;
    }

    public function get_auth_login_reserva_socio(Request $Request)
    {

        if (Session::has('socio-auth')) {
            Session::forget('socio-auth');
        }

        $Empresa = $Request->get('empresa_desde_middleware');

        $Data = [
            'title'       => $Empresa->name . ' | Reserva de clases online',
            'img'         => $Empresa->url_img,
            'description' => '',
        ];

        Session::put('empresa_auth_public', $Empresa);

        return view('empresa_gestion_paginas.Vue_logica.Componentes.EmpresaReservasYPanelSocioPublico.empresa_reserva_log_in', compact('Empresa', 'Data'));
    }

    public function post_auth_login_reserva_socio(Request $Request)
    {
        $Empresa = Session::get('empresa_auth_public');

        $Celular = $Request->get('celular');

        $SocioRepo = new SocioRepo();
        $Socio     = $SocioRepo->getSocioConCelularDeEstaEmpresa($Empresa->id, $Celular);

        if ($Socio->count() > 0) {
            Session::put('socio-auth', $Socio->first());

            return redirect()->route('get_panel_de_reservas');
        } else {

            return redirect()->back()->with('alert-danger', 'No tenemos ningún socio registrado con este celular 👉 ' . $Celular . ' . Llamanos al ' . $Empresa->celular . ' para arreglar esto.');
        }
    }
}
