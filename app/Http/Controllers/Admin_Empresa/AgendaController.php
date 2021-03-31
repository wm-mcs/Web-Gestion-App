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
        return ['name', 'hora_inicio', 'hora_fin', 'actividad_id', 'tiene_limite_de_cupos', 'cantidad_de_cupos', 'empresa_id', 'sucursal_id'];
    }

    public function cleanCache($customCache)
    {
        HelpersGenerales::forgetEsteCache($customCache);
    }

    public function getEntidades(Request $Request)
    {
        $Empresa_id = $Request->get('user_empresa_desde_middleware')->empresa_id;
        $Sucursal   = $Request->get('sucursal_desde_middleware');
        $Entidades  = $this->EntidadRepo->getAgendasDeEstaSucursal($Empresa_id, $Sucursal->id, 'id', 'desc', null);

        return HelpersGenerales::formateResponseToVue(true, 'Se cargaron los cronogramas', $Entidades);
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

        $this->cleanCache('ActividadAgenda' . $Entidad->id);

        return HelpersGenerales::formateResponseToVue(true, 'Se creó correctamente');
    }

    //editar
    public function editarEntidad(Request $Request)
    {
        $manager = $this->getManager($Request);

        if (!$manager->isValid()) {
            return HelpersGenerales::formateResponseToVue(false, 'No se pudó crear', $manager->getErrors());
        }

        $Entidad = $this->EntidadRepo->find($Request->get('id'));

        $Entidad = $this->EntidadRepo->setAtributoEspecifico($Entidad, 'days', implode(',', $Request->get('days')));

        $Entidad = $this->EntidadRepo->setEntidadDato($Entidad, $Request, $this->getPropiedades());

        $this->cleanCache('ActividadAgenda' . $Entidad->id);

        return HelpersGenerales::formateResponseToVue(true, 'Se editó correctamente');
    }

    //borrar lógico
    public function eliminarEntidad(Request $Request)
    {
        $Entidad = $this->EntidadRepo->find($Request->get('id'));

        $this->EntidadRepo->destruir_esta_entidad_de_manera_logica($Entidad);

        $this->cleanCache('ActividadAgenda' . $Entidad->id);

        return HelpersGenerales::formateResponseToVue(true, 'Se borró la actividad');
    }
}
