<?php

namespace App\Http\Controllers\Admin_Empresa;

use App\Helpers\HelpersGenerales;
use App\Http\Controllers\Controller;
use App\Repositorios\CajaEmpresaRepo;
use App\Repositorios\EmpresaConSociosoRepo;
use App\Repositorios\ServicioContratadoSocioRepo;
use App\Repositorios\TipoDeMovimientoRepo;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AnaliticasController extends Controller
{
    protected $EmpresaConSociosoRepo;
    protected $TipoDeMovimientoRepo;
    protected $CajaEmpresaRepo;
    protected $ServicioContratadoSocioRepo;

    public function __construct(EmpresaConSociosoRepo $EmpresaConSociosoRep,
        TipoDeMovimientoRepo $TipoDeMovimientoRepo,
        CajaEmpresaRepo $CajaEmpresaRepo,
        ServicioContratadoSocioRepo $ServicioContratadoSocioRepo) {
        $this->EmpresaConSociosoRepo = $EmpresaConSociosoRep;
        $this->TipoDeMovimientoRepo = $TipoDeMovimientoRepo;
        $this->CajaEmpresaRepo = $CajaEmpresaRepo;
        $this->ServicioContratadoSocioRepo = $ServicioContratadoSocioRepo;
    }

    public function get_analiticas(Request $Request)
    {
        $UserEmpresa = $Request->get('user_empresa_desde_middleware');
        $Empresa = $this->EmpresaConSociosoRepo->find($UserEmpresa->empresa_id);
        return view('empresa_gestion_paginas.Vue_logica.Componentes.Analiticas.panel_analiticas', compact('Empresa'));
    }

    public function get_movimientos_de_caja_para_analiticas(Request $Request)
    {
        $Fecha_inicio = $Request->get('fecha_inicio') != null ? Carbon::parse($Request->get('fecha_inicio')) : Carbon::now('America/Montevideo')->subMonth()->startOfMonth();
        $Fecha_fin = $Request->get('fecha_fin') != null ? Carbon::parse($Request->get('fecha_fin')) : Carbon::now('America/Montevideo')->subMonth()->endOfMonth();

        $keys = [
            ['where_tipo' => 'where',
                'key' => 'empresa_id',
                'value' => $Request->get('empresa_id'),
            ],
            [
                'where_tipo' => 'whereBetween',
                'key' => 'fecha_ingreso',
                'value' => ['start' => $Fecha_inicio, 'end' => $Fecha_fin],
            ],

        ];

        $Movimientos = $this->CajaEmpresaRepo->getEntidadesMenosIdsYConFiltros($keys, [], null, 'fecha_ingreso', 'desc', 'no');

        return HelpersGenerales::formateResponseToVue(true, 'Datos cargados', ['Movimientos' => $Movimientos, 'fecha_inicio' => $Fecha_inicio->format('Y-m-d'), 'fecha_fin' => $Fecha_fin->format('Y-m-d')]);
    }

    public function get_servicios_vendidos(Request $Request)
    {
        $Fecha_inicio = $Request->get('fecha_inicio') != null ? Carbon::parse($Request->get('fecha_inicio')) : Carbon::now('America/Montevideo')->subMonth()->startOfMonth();
        $Fecha_fin = $Request->get('fecha_fin') != null ? Carbon::parse($Request->get('fecha_fin')) : Carbon::now('America/Montevideo')->subMonth()->endOfMonth();

        $keys = [
            ['where_tipo' => 'where',
                'key' => 'empresa_id',
                'value' => $Request->get('empresa_id'),
            ],
            [
                'where_tipo' => 'whereBetween',
                'key' => 'created_at',
                'value' => ['start' => $Fecha_inicio, 'end' => $Fecha_fin],
            ],

        ];

        $Servicios = $this->ServicioContratadoSocioRepo->getEntidadesMenosIdsYConFiltros($keys, [], null, 'created_at', 'desc', 'no');
        return HelpersGenerales::formateResponseToVue(true, 'Datos cargados', ['Servicios' => $Servicios, 'fecha_inicio' => $Fecha_inicio->format('Y-m-d'), 'fecha_fin' => $Fecha_fin->format('Y-m-d')]);
    }

}
