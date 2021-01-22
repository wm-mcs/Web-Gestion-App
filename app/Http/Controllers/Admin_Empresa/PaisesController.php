<?php

namespace App\Http\Controllers\Admin_Empresa;

use App\Helpers\HelpersGenerales;
use Illuminate\Http\Request;
use App\Repositorios\PaisRepo;
use App\Http\Controllers\Controller;
use App\Managers\EmpresaGestion\PaisManager;
use App\Http\Controllers\Traits\validatorMesaagesTrait;


class PaisesController extends Controller
{


  use validatorMesaagesTrait;

  protected $TipoDeMovimientoRepo;

  public function __construct(PaisRepo $PaisRepo)
  {
    $this->PaisRepo = $PaisRepo;
  }


  public function getPropiedades()
  {
    return ['name','tipo_saldo','movimiento_de_empresa_a_socio','movimiento_de_la_empresa','descripcion_breve','estado','se_muestra_en_panel','socio_opcion_de_pago','se_paga'];
  }

  /**
   * Regresa el manager del controlador
   *
   * @return validator object
   */
  public function getValidatorData($Request)
  {
    $Manager = new PaisManager( null, $Request->all());
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

  










}