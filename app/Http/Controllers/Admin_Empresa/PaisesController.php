<?php

namespace App\Http\Controllers\Admin_Empresa;

use App\Helpers\HelpersGenerales;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\validatorMesaagesTrait;
use App\Managers\EmpresaGestion\PaisManager;
use App\Repositorios\PaisRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PaisesController extends Controller
{
    use validatorMesaagesTrait;

    protected $PaisRepo;

    public function __construct(PaisRepo $PaisRepo)
    {
        $this->PaisRepo = $PaisRepo;
    }

    public function getPropiedades()
    {
        return ['name', 'code', 'currencyCode', 'cell_phone_code', 'estado'];
    }

    /**
     * Regresa el manager del controlador
     *
     * @return validator object
     */
    public function getValidatorData($Request)
    {
        $Manager = new PaisManager(null, $Request->all());
        return $Manager;
    }

    /**
     * Me manda a la vista para gestionar todo esto
     *
     * @return void
     */
    public function getIndex()
    {
        return view('empresa_gestion_paginas.Administrador.paises');
    }

    public function crear_pais(Request $Request)
    {
        $manager = new PaisManager(null, $Request->all());

        if (!$manager->isValid()) {
            return ['Validacion' => false,
                'Validacion_mensaje' => 'No se pudo crear: ' . $manager->getErrors()];

        }

        $Propiedades = $this->getPropiedades();

        $Entidad          = $this->PaisRepo->getEntidad();
        $Entidad->borrado = 'no';

        $Entidad = $this->PaisRepo->setEntidadDato($Entidad, $Request, $Propiedades);
        $this->PaisRepo->setImagenDesdeVue($Request->get('imagen'), 'Paises/', str_replace(' ', '-', $Request->get('name')), '.png', 100);

        $this->PaisRepo->ActualizarCache();

        return HelpersGenerales::formateResponseToVue(true, 'Se creó correctamente el país', Cache::remember('Paises', 10000, function () {
            return $this->PaisRepo->getEntidadesMenosIdsYConFiltros(null, [], null, 'name', 'asc', 'no');
        }));

    }

    public function editar_pais(Request $Request)
    {

        $Pais = json_decode(json_encode($Request->get('pais')));

        $Validacion = true;

        $PaisBuscado = $this->PaisRepo->find($Pais->id);

        //las porpiedades que se van a editar
        $Propiedades = $this->getPropiedades();

        $this->PaisRepo->setEntidadDatoObjeto($PaisBuscado, $Pais, $Propiedades);

        $this->PaisRepo->setImagenDesdeVue($Request->get('imagen'), 'Paises/', str_replace(' ', '-', $PaisBuscado->name), '.png', 100);

        //actualizo cache socio
        $this->PaisRepo->ActualizarCache();

        return HelpersGenerales::formateResponseToVue(true, 'Se ceditó correctamente el país', Cache::remember('Paises', 10000, function () {
            return $this->PaisRepo->getEntidadesMenosIdsYConFiltros(null, [], null, 'name', 'asc', 'no');
        }));
    }

    public function get_paises_todos(Request $Request)
    {

        return HelpersGenerales::formateResponseToVue(true, 'Paises todos', $this->PaisRepo->getEntidadesMenosIdsYConFiltros(null, [], null, 'name', 'asc', 'no'));
    }

    /**
     *  Api pública
     */
    public function get_paises(Request $Request)
    {

        if (Auth::guest()) {
            //crear un tokrn y guardarlo en la base de datos
            //crear un tokrn y guardarlo en la base de datos
        } else {

        }

        $Paises = Cache::remember('Paises', 10000, function () {
            return $this->PaisRepo->getEntidadActivasOrdenadasSegun('name', 'asc');
        });

        return ['Validacion' => true,
            'Validacion_mensaje' => 'Países cargados correctamente',
            'Paises'             => $Paises,
            'Header'             => $Request->header('Ip'),
            'Header2'            => $Request->header('Maurico'),
            'cache'              => $Request->get('cache')];

    }
}
