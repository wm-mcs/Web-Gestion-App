<?php

namespace App\Http\Controllers\Admin_Empresa;

use App\Helpers\HelpersGenerales;
use App\Http\Controllers\Controller;
use App\Interfases\EntidadCrudInterface;
use App\Managers\EmpresaGestion\CrearTipoServicioManager;
use App\Repositorios\EmpresaConSociosoRepo;
use App\Repositorios\TipoDeServicioRepo;
use Illuminate\Http\Request;

class ServiciosController extends Controller implements EntidadCrudInterface
{
    protected $EmpresaConSociosoRepo;
    protected $EntidadRepo;

    public function __construct(EmpresaConSociosoRepo $EmpresaConSociosoRep,
        TipoDeServicioRepo $EntidadRepo) {
        $this->EmpresaConSociosoRepo = $EmpresaConSociosoRep;
        $this->EntidadRepo           = $EntidadRepo;
    }

    public function getManager(Request $Request)
    {
        return new CrearTipoServicioManager(null, $Request->all());
    }

    public function getPropiedades()
    {
        return ['name', 'tipo', 'renovacion_cantidad_en_dias', 'empresa_id', 'moneda', 'valor', 'cantidad_clases'];
    }

    public function cleanCache($customCache)
    {
        HelpersGenerales::forgetEsteCache($customCache);
    }

    public function getIndex(Request $Request)
    {
        $UserEmpresa = $Request->get('user_empresa_desde_middleware');
        $Empresa     = $this->EmpresaConSociosoRepo->find($UserEmpresa->empresa_id);

        return view('empresa_gestion_paginas.Vue_logica.Componentes.ConfiguracionEmpresas.servicios', compact('Empresa'));
    }

    public function getEntidades(Request $Request)
    {
        $Empresa_id = $Request->get('user_empresa_desde_middleware')->empresa_id;

        return HelpersGenerales::formateResponseToVue(true, 'Se cargaron servicios', $this->EntidadRepo->getEntidadesDeEstaEmpresa($Empresa_id, 'name', 'desc', false, 'no'));
    }

    public function get_tipo_servicios($empresa_id)
    {
        $Validacion = true;

        return ['Validacion' => $Validacion,
            'Validacion_mensaje' => 'Se cargó correctamente',
            'servicios'          => $this->EntidadRepo->getServiciosActivosDeEmpresa($empresa_id)];
    }

    //agrega un nuevo tipo de servicio ( Tipo Clase o Tipo Mensual )
    public function crearEntidad(Request $Request)
    {
        $User = $Request->get('user_desde_middleware');

        $Empresa = $this->EmpresaConSociosoRepo->find($Request->get('empresa_id'));

        $Entidad = $this->EntidadRepo->getEntidad();

        $manager = $this->getManager();

        if (!$manager->isValid()) {
            return ['Validacion' => false,
                'Validacion_mensaje' => 'No se pudo crear el servicio: ' . $manager->getErrors()];
        }

        $Entidad->estado = 'si';
        $Entidad->moneda = '$';
        $Entidad->valor  = 0;

        $Entidad = $this->EntidadRepo->setEntidadDato($Entidad, $Request, $this->getPropiedades());

        $this->cleanCache('tipoDeServiciosEmpresa' . $Entidad->id);

        $Validacion = true;

        return ['Validacion' => $Validacion,
            'Validacion_mensaje' => 'Se creo correctamente ',
            'empresa'            => $Empresa];
    }

    //borrar un servicio
    public function eleminarEntidad(Request $Request)
    {
        $Entidad = $this->EntidadRepo->find($Request->get('id'));
        $Empresa = $this->EmpresaConSociosoRepo->find($Request->get('empresa_id'));

        $this->cleanCache('tipoDeServiciosEmpresa' . $Entidad->id);

        $this->EntidadRepo->destruir_esta_entidad_de_manera_logica($Entidad);

        $Validacion = true;

        return ['Validacion' => $Validacion,
            'Validacion_mensaje' => 'Se borró correctamente ',
            'empresa'            => $Empresa];
    }

    //editar un servicio
    public function editarEntidad(Request $Request)
    {
        $User       = $Request->get('user_desde_middleware');
        $Validacion = true;
        $Servicio   = $Request->get('servicio'); //me manda la data en array vue
        $Entidad    = $this->EntidadRepo->find($Servicio['id']);
        $Empresa    = $this->EmpresaConSociosoRepo->find($Request->get('empresa_id'));

        foreach ($this->getPropiedades() as $Propiedad) {
            $Entidad->$Propiedad = $Servicio[$Propiedad];
        }

        $Entidad->save();

        $this->cleanCache('tipoDeServiciosEmpresa' . $Entidad->id);

        return ['Validacion' => $Validacion,
            'Validacion_mensaje' => 'Se editó correctamente ',
            'empresa'            => $Empresa];
    }
}
