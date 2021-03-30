<?php

namespace App\Http\Controllers\Admin_Empresa;

use App\Helpers\HelpersGenerales;
use App\Http\Controllers\Controller;
use App\Interfases\EntidadCrudInterface;
use App\Managers\EmpresaGestion\AgendaManager;
use App\Repositorios\AgendaRepo;
use App\Repositorios\EmpresaConSociosoRepo;
use Illuminate\Http\Request;

class AgendaController extends Controller implements EntidadCrudInterface
{
    protected $EmpresaConSociosoRepo;
    protected $EntidadRepo;

    public function __construct(EmpresaConSociosoRepo $EmpresaConSociosoRep,
        AgendaRepo $AgendaRepo) {
        $this->EmpresaConSociosoRepo = $EmpresaConSociosoRep;
        $this->EntidadRepo           = $AgendaRepo;
    }

    public function getIndex(Request $Request)
    {
        $UserEmpresa = $Request->get('user_empresa_desde_middleware');
        $Empresa     = $this->EmpresaConSociosoRepo->find($UserEmpresa->empresa_id);

        return view('empresa_gestion_paginas.Vue_logica.Componentes.ConfiguracionEmpresas.agenda', compact('Empresa'));
    }

    public function getManager(Request $Request)
    {
        return new AgendaManager(null, $Request->all());
    }

    public function getPropiedades()
    {
        return ['name', 'hora_inicio', 'hora_fin', 'actividad_id', 'tiene_limite_de_cupos', 'empresa_id', 'sucursal_id'];
    }

    public function cleanCache($customCache)
    {
        HelpersGenerales::forgetEsteCache($customCache);
    }

    public function getEntidades(Request $Request)
    {
    }

    public function get_tipo_servicios($empresa_id)
    {
    }

    //agrega un nuevo tipo de servicio ( Tipo Clase o Tipo Mensual )
    public function crearEntidad(Request $Request)
    {
        $manager = $this->getManager($Request);

        if (!$manager->isValid()) {
            return HelpersGenerales::formateResponseToVue(false, 'No se pudó crear', $manager->getErrors());
        }

        $Entidad = $this->EntidadRepo->getEntidad();

        $Entidad->estado = 'si';

        $Entidad = $this->EntidadRepo->setAtributoEspecifico($Entidad, 'days', implode(',', $Request->get('days')));

        $Entidad = $this->EntidadRepo->setEntidadDato($Entidad, $Request, $this->getPropiedades());

        $this->cleanCache('ActividadAgenda' . $Entidad->actividad_id);

        return HelpersGenerales::formateResponseToVue(true, 'Se creó correctamente');
    }

    //editar un servicio
    public function editarEntidad(Request $Request)
    {
    }
}
