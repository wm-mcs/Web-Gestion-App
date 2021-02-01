<?php

namespace App\Http\Controllers\Admin_Empresa;

use App\Http\Controllers\Controller;

class AnaliticasController extends Controller
{

    public function __construct()
    {

    }

    public function get_analiticas()
    {
        return view('empresa_gestion_paginas.Vue_logica.Componentes.Analiticas.panel_analiticas');
    }

}
