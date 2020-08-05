<?php

namespace App\Http\Controllers\Admin_Empresa;
use Illuminate\Http\Request;
use App\Repositorios\TipoDeMovimientoRepo;
use App\Http\Controllers\Controller;
use App\Managers\EmpresaGestion\TipoMovimiento\TipoDeMovimientoManager;
use App\Http\Controllers\Traits\vvalidatorMesaagesTrait;


class TipoDeMovimientoController extends Controller
{


  use vvalidatorMesaagesTrait;

  protected $TipoDeMovimientoRepo;

  public function __construct(TipoDeMovimientoRepo $TipoDeMovimientoRepo)
  {
    $this->TipoDeMovimientoRepo = $TipoDeMovimientoRepo;
  }


  public function getPropiedades()
  {
    return ['name','tipo_saldo','movimiento_de_empresa_a_socio','movimiento_de_la_empresa'];
  }

  /**
   * Regresa el manager del controlador
   *
   * @return validator object
   */
  public function getValidatorData($Request)
  {
    $Manager = new TipoDeMovimientoManager( null, $Request->all());
    return $Manager;
  }

  /**
   * Me manda a la vista para gestionar todo esto
   *
   * @return void
   */
  public function getIndex()
  {
    return view('empresa_gestion_paginas.Administrador.tipo_de_movimientos');
  }

  /**
   * Me da los movimientos. La llamo desde el componente de Vue.
   *
   * @return 
   */
  public function get_tipo_de_movimientos()
  {

  	$Tipo_de_movimientos = $this->TipoDeMovimientoRepo->getEntidadActivasOrdenadasSegun('name','asc');
  	
  	return ['Validacion'           => true,
            'Validacion_mensaje'   => 'Se cargaron correctamente los movimientos',
            'Tipo_de_movimientos'  =>  $Tipo_de_movimientos]; 
  }



  /**
   * Crea un nuevo tipo de movimiento
   *
   * @return array
   */
  public function set_un_tipo_de_movimiento(Request $Request)
  {
    $manager = $this->getValidatorData($Request);

    if(!$manager->isValid())
    {
      return $this->getErroresCuandoNoPasaValidator($manager);
    }

    $this->TipoDeMovimientoRepo->setEntidadDato(null,$Request,$this->getPropiedades());
  }
}