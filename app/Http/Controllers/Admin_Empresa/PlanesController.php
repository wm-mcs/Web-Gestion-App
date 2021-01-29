<?php

namespace App\Http\Controllers\Admin_Empresa;

use App\Helpers\HelpersGenerales;
use App\Http\Controllers\Controller;
use App\Managers\EmpresaGestion\CrearPlanManager;
use App\Repositorios\EmpresaConSociosoRepo;
use App\Repositorios\MovimientoEstadoDeCuentaEmpresaRepo;
use App\Repositorios\SucursalEmpresaRepo;
use App\Repositorios\TipoDeServicioAEmpresaRepo;
use App\Repositorios\UserEmpresaRepo;
use App\Repositorios\UserRepo;
use App\Repositorios\VendedorEmpresaRepo;
use Illuminate\Http\Request;

class PlanesController extends Controller
{

    protected $EmpresaConSociosoRepo;
    protected $MovimientoEstadoDeCuentaEmpresaRepo;
    protected $UserRepo;
    protected $UserEmpresaRepo;
    protected $VendedorEmpresaRepo;
    protected $TipoDeServicioAEmpresaRepo;
    protected $SucursalEmpresaRepo;

    public function __construct(EmpresaConSociosoRepo $EmpresaConSociosoRepo,
        MovimientoEstadoDeCuentaEmpresaRepo $MovimientoEstadoDeCuentaEmpresaRepo,
        UserRepo $UserRepo,
        UserEmpresaRepo $UserEmpresaRepo,
        VendedorEmpresaRepo $VendedorEmpresaRepo,
        TipoDeServicioAEmpresaRepo $TipoDeServicioAEmpresaRepo,
        SucursalEmpresaRepo $SucursalEmpresaRepo

    ) {
        $this->EmpresaConSociosoRepo = $EmpresaConSociosoRepo;
        $this->MovimientoEstadoDeCuentaEmpresaRepo = $MovimientoEstadoDeCuentaEmpresaRepo;
        $this->UserRepo = $UserRepo;
        $this->UserEmpresaRepo = $UserEmpresaRepo;
        $this->VendedorEmpresaRepo = $VendedorEmpresaRepo;
        $this->TipoDeServicioAEmpresaRepo = $TipoDeServicioAEmpresaRepo;
        $this->SucursalEmpresaRepo = $SucursalEmpresaRepo;

    }

    public function getPropiedades()
    {
        return ['name', 'tipo', 'moneda', 'valor', 'cantidad_socios', 'cantidad_sucursales', 'estado', 'control_acceso', 'valor_fuera_de_uruguay'];

    }

    public function get_planes_empresa(Request $Request)
    {
        $planes = $this->TipoDeServicioAEmpresaRepo->getServiciosActivosAEmpresas();
        return HelpersGenerales::formateResponseToVue(true, 'Planes agregados corectamente', $planes);

    }

    public function get_planes_index()
    {
        return view('empresa_gestion_paginas.Administrador.planes');
    }

    public function crear_plan(Request $Request)
    {
        $manager = new CrearPlanManager(null, $Request->all());
        if (!$manager->isValid()) {
            return ['Validacion' => false,
                'Validacion_mensaje' => 'No se pudó crear el plan: ' . $manager->getErrors()];
        }

        $Propiedades = $this->getPropiedades();

        $this->TipoDeServicioAEmpresaRepo->setEntidadDato($this->TipoDeServicioAEmpresaRepo->getEntidad(), $Request, $Propiedades);

        $planes = $this->TipoDeServicioAEmpresaRepo->getServiciosActivosAEmpresas();

        return ['Validacion' => true,
            'Validacion_mensaje' => 'Planes agregados corectamente',
            'planes' => $planes];

    }

    public function editar_plan_empresa(Request $Request)
    {
        $Plan = $Request->get('plan'); //me manda la data en array vue
        $Entidad = $this->TipoDeServicioAEmpresaRepo->find($Plan['id']);

        //las porpiedades que se van a editar
        $Propiedades = $this->getPropiedades();

        foreach ($Propiedades as $Propiedad) {
            $Entidad->$Propiedad = $Plan[$Propiedad];
        }

        $Entidad->save();

        return HelpersGenerales::formateResponseToVue(true, 'Se editó correctamente ', $this->TipoDeServicioAEmpresaRepo->getServiciosActivosAEmpresas());

    }

}
