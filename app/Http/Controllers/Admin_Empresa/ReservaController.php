<?php

namespace App\Http\Controllers\Admin_Empresa;

use App\Http\Controllers\Controller;
use App\Repositorios\EmpresaConSociosoRepo;
use Illuminate\Http\Request;

class ReservaController extends Controller
{
    protected $EmpresaConSociosoRepo;

    public function __construct(EmpresaConSociosoRepo $EmpresaConSociosoRep
    ) {
        $this->EmpresaConSociosoRepo = $EmpresaConSociosoRep;

    }

    public function get_panel_de_empresa_publico(Request $Request)
    {
        $Empresa = $Request->get('empresa_desde_middleware');

        $Data = [
            'title'       => $Empresa->name,
            'img'         => $Empresa->name,
            'description' => '',
        ];

        return view('empresa_gestion_paginas.Vue_logica.Componentes.EmpresaReservasYPanelSocioPublico.empresa_reserva', compact('Empresa', 'Data'));
    }

}
