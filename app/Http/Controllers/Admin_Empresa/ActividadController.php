<?php

namespace App\Http\Controllers\Admin_Empresa;

use App\Http\Controllers\Controller;
use App\Repositorios\EmpresaConSociosoRepo;
use Illuminate\Http\Request;

class ActividadController extends Controller
{
    protected $EmpresaConSociosoRepo;

    public function __construct(EmpresaConSociosoRepo $EmpresaConSociosoRep)
    {
        $this->EmpresaConSociosoRepo = $EmpresaConSociosoRep;
    }

    public function getIndex(Request $Request)
    {
        $UserEmpresa = $Request->get('user_empresa_desde_middleware');
        $Empresa     = $this->EmpresaConSociosoRepo->find($UserEmpresa->empresa_id);

        return view('empresa_gestion_paginas.Vue_logica.Componentes.ConfiguracionEmpresas.agenda', compact('Empresa'));
    }
}
