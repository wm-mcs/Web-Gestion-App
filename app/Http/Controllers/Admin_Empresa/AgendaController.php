<?php

namespace App\Http\Controllers\Admin_Empresa;

use App\Helpers\HelpersGenerales;
use App\Http\Controllers\Controller;
use App\Interfases\EntidadCrudInterface;
use App\Repositorios\EmpresaConSociosoRepo;
use Illuminate\Http\Request;

class AgendaController extends Controller implements EntidadCrudInterface
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

    public function getEntidades(Request $Request)
    {

    }

    public function get_tipo_servicios($empresa_id)
    {

    }

    //agrega un nuevo tipo de servicio ( Tipo Clase o Tipo Mensual )
    public function crearEntidad(Request $Request)
    {

    }

    //editar un servicio
    public function editarEntidad(Request $Request)
    {

    }
}
