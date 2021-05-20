<?php

namespace App\Http\Controllers\Admin_Empresa;

use App\Helpers\HelpersGenerales;
use App\Http\Controllers\Controller;
use App\Interfases\EntidadCrudInterface;
use App\Managers\EmpresaGestion\GrupoManager;
use App\Repositorios\EmpresaConSociosoRepo;
use App\Repositorios\GrupoRepo;
use App\Repositorios\GrupoSocioRelacionRepo;
use Illuminate\Http\Request;

class GrupoController extends Controller implements EntidadCrudInterface
{
    protected $EmpresaConSociosoRepo;
    protected $EntidadRepo;

    public function __construct(EmpresaConSociosoRepo $EmpresaConSociosoRep,
        GrupoRepo $GrupoRepo) {
        $this->EmpresaConSociosoRepo = $EmpresaConSociosoRep;
        $this->EntidadRepo           = $GrupoRepo;
    }

    public function getManager(Request $Request)
    {
        return new GrupoManager(null, $Request->all());
    }

    public function getPropiedades()
    {
        return ['empresa_id', 'sucursal_id', 'name', 'description', 'estado', 'color'];
    }

    public function cleanCache($customCache)
    {
        HelpersGenerales::forgetEsteCache($customCache);
    }

    public function getIndex(Request $Request)
    {
        $UserEmpresa = $Request->get('user_empresa_desde_middleware');
        $Empresa     = $this->EmpresaConSociosoRepo->find($UserEmpresa->empresa_id);

        return view('empresa_gestion_paginas.Vue_logica.Componentes.ConfiguracionEmpresas.grupos', compact('Empresa'));
    }

    public function getEntidades(Request $Request)
    {
        $Empresa_id = $Request->get('user_empresa_desde_middleware')->empresa_id;

        return HelpersGenerales::formateResponseToVue(true, 'Se cargaron ', $this->EntidadRepo->getGrupos($Empresa_id, $Request->get('sucursal_id')));
    }

    public function crearEntidad(Request $Request)
    {
        $manager = $this->getManager($Request);

        if ($manager->isValid()) {
            $Entidad = $this->EntidadRepo->getEntidad();
            $Entidad = $this->EntidadRepo->setEntidadDato($Entidad, $Request, $this->getPropiedades());
            $this->EntidadRepo->setAtributoEspecifico($Entidad, 'borrado', 'no');

            return HelpersGenerales::formateResponseToVue(true, 'Se creó correctamente');
        }

        return HelpersGenerales::formateResponseToVue(false, 'No se pudo crear', $manager->getErrors());
    }

    public function editarEntidad(Request $Request)
    {
        $manager = $this->getManager($Request);

        if ($manager->isValid()) {
            $Entidad = $this->EntidadRepo->find($Request->get('id'));
            $Entidad = $this->EntidadRepo->setEntidadDato($Entidad, $Request, $this->getPropiedades());

            return HelpersGenerales::formateResponseToVue(true, 'Se editó correctamente');
        }

        return HelpersGenerales::formateResponseToVue(false, 'No se pudo editar', $manager->getErrors());
    }

    public function eliminarGrupo(Request $Request)
    {
        $RepoGrupoSocioRelacion = new GrupoSocioRelacionRepo();
        $UserEmpresa            = $Request->get('user_empresa_desde_middleware');
        $Empresa                = $this->EmpresaConSociosoRepo->find($UserEmpresa->empresa_id);
        $GrupoRelacionados      = $RepoGrupoSocioRelacion->getRelacionesDeEsteGrupo($Empresa->id, $Request->get('sucursal_id'), $Request->get('grupo_id'));

        foreach ($GrupoRelacionados as $Relacion) {
            $RepoGrupoSocioRelacion->destroy_entidad($Relacion);
        }

        $this->EntidadRepo->destruir_esta_entidad_de_manera_logica($this->EntidadRepo->find($Request->get('grupo_id')));

        return HelpersGenerales::formateResponseToVue(true, 'Se eliminó el grupo correctamente');

    }
}
