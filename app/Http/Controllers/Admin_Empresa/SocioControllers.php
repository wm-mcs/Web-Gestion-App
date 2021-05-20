<?php

namespace App\Http\Controllers\Admin_Empresa;

use App\Helpers\HelpersGenerales;
use App\Http\Controllers\Controller;
use App\Managers\EmpresaGestion\VincularGrupoASocio;
use App\Repositorios\EmpresaConSociosoRepo;
use App\Repositorios\GrupoRepo;
use App\Repositorios\GrupoSocioRelacionRepo;
use App\Repositorios\SocioRepo;
use Illuminate\Http\Request;

class SocioControllers extends Controller
{
    protected $EmpresaConSociosoRepo;
    protected $GrupoRepo;
    protected $SocioRepo;
    protected $GrupoSocioRelacionRepo;

    public function __construct(EmpresaConSociosoRepo $EmpresaConSociosoRep,
        GrupoRepo $GrupoRepo,
        SocioRepo $SocioRepo,
        GrupoSocioRelacionRepo $GrupoSocioRelacionRepo) {
        $this->EmpresaConSociosoRepo  = $EmpresaConSociosoRep;
        $this->GrupoRepo              = $GrupoRepo;
        $this->GrupoSocioRelacionRepo = $GrupoSocioRelacionRepo;
    }

    public function vincular_socio_con_grupo(Request $Request)
    {
        $User        = $Request->get('user_desde_middleware');
        $Socio_id    = $Request->get('socio_desde_middleware')->id;
        $UserEmpresa = $Request->get('user_empresa_desde_middleware');
        $Empresa     = $this->EmpresaConSociosoRepo->find($UserEmpresa->empresa_id);
        $Grupo_id    = $Request->get('grupo_id');

        $manager = new VincularGrupoASocio(null, $Request->all());

        if ($manager->isValid()) {
            $this->GrupoSocioRelacionRepo->vincularSocioAGrupo($Empresa->id, $Request->get('sucursal_id'), $Socio_id, $Grupo_id);

            return HelpersGenerales::formateResponseToVue(true, 'Se vinculó correctamente');
        }

        return HelpersGenerales::formateResponseToVue(false, 'No se pudo vincular', $manager->getErrors());

    }

    public function desvincular_socio_con_grupo(Request $Request)
    {
        $Socio_id    = $Request->get('socio_desde_middleware')->id;
        $UserEmpresa = $Request->get('user_empresa_desde_middleware');
        $Empresa     = $this->EmpresaConSociosoRepo->find($UserEmpresa->empresa_id);
        $Grupo_id    = $Request->get('grupo_id');

        $this->GrupoSocioRelacionRepo->desVincularSocioAGrupo($Empresa->id, $Request->get('sucursal_id'), $Socio_id, $Grupo_id);

        return HelpersGenerales::formateResponseToVue(true, 'Se Desvinculó correctamente');
    }

    public function get_grupos_del_socio(Request $Request)
    {

        $Socio_id    = $Request->get('socio_desde_middleware')->id;
        $UserEmpresa = $Request->get('user_empresa_desde_middleware');
        $Empresa     = $this->EmpresaConSociosoRepo->find($UserEmpresa->empresa_id);
        $Relaciones  = $this->GrupoSocioRelacionRepo->getRelacionesDeGruposDeEstSocio($Empresa->id, $Socio_id);
        $Grupos      = '';

        if ($Relaciones->count() > 0) {
            $Array_id_grupos = $Relaciones->map(function ($Relacion, $key) {
                return $Relacion->grupo_id;
            })->values();

            $Grupos = $this->GrupoRepo->getEntidadesConEstosId($Array_id_grupos->all());

        } else {
            $Grupos = [];
        }

        return HelpersGenerales::formateResponseToVue(true, 'Se cargaron los grupos', $Grupos);

    }

}
