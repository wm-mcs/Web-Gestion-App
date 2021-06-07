<?php

namespace App\Http\Controllers\Admin_Empresa;

use App\Helpers\HelpersGenerales;
use App\Http\Controllers\Controller;
use App\Managers\EmpresaGestion\AvisoEmpresaManager;
use App\Repositorios\AvisoEmpresaRepo;
use App\Repositorios\EmpresaConSociosoRepo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AvisosController extends Controller
{
    protected $EmpresaConSociosoRepo;
    protected $AvisoEmpresaRepo;

    public function __construct(EmpresaConSociosoRepo $EmpresaConSociosoRep,
        AvisoEmpresaRepo $AvisoEmpresaRepo) {

        $this->EmpresaConSociosoRepo = $EmpresaConSociosoRep;
        $this->AvisoEmpresaRepo      = $AvisoEmpresaRepo;
    }

    public function getManager(Request $Request)
    {
        return new AvisoEmpresaManager(null, $Request->all());
    }

    public function getPropiedades()
    {
        return ['empresa_id', 'title', 'text', 'type', 'leido', 'call_to_action', 'call_to_action_url', 'leido_por'];
    }

    public function get_avisos_de_esta_empresa(Request $Request)
    {
        return HelpersGenerales::formateResponseToVue(true, 'Avisos cargados', $this->AvisoEmpresaRepo->getAvisosDeEmpresa($Request->get('empresa_id')));
    }

    public function crear_aviso_empresa(Request $Request)
    {
        $manager = $this->getManager($Request);

        if ($manager->isValid()) {
            $Entidad          = $this->AvisoEmpresaRepo->getEntidad();
            $Entidad->estado  = 'si';
            $Entidad->borrado = 'no';
            $this->AvisoEmpresaRepo->setEntidadDato($Entidad, $Request, $this->getPropiedades());

            if ($Request->get('tambien_se_envia_email') == 'si') {
                //Enviar email
            }

            return HelpersGenerales::formateResponseToVue(true, 'Se creó el aviso');
        }
        return HelpersGenerales::formateResponseToVue(false, 'No se pudo crear', $manager->getErrors());

    }

    public function confirmar_lectura_de_aviso(Request $Request)
    {
        $Aviso   = $this->AvisoEmpresaRepo->find($Request->get('aviso_id'));
        $Empresa = $this->EmpresaConSociosoRepo->find($Request->get('empresa_id'));

        if ($Aviso->empresa_id != $Request->get('empresa_id')) {
            return HelpersGenerales::formateResponseToVue(false, 'Algo no está bien. Te estás portando mal picaron.');
        }

        $this->AvisoEmpresaRepo->setAtributoEspecifico($Aviso, 'leido', 'si');
        $this->AvisoEmpresaRepo->setAtributoEspecifico($Aviso, 'leido_por', Auth::user()->name);
        $this->AvisoEmpresaRepo->setAtributoEspecifico($Aviso, 'fecha_leido', Carbon::now($Empresa->zona_horaria));

        return HelpersGenerales::formateResponseToVue(true, 'Se confirmó lectura');
    }

}
