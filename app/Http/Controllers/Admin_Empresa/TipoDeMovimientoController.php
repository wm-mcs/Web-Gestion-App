<?php

namespace App\Http\Controllers\Admin_Empresa;
use Illuminate\Http\Request;
use App\Repositorios\TipoDeMovimientoRepo;
use App\Http\Controllers\Controller;



class TipoDeMovimientoController extends Controller
{
  protected $TipoDeMovimientoRepo;

  public function __construct(TipoDeMovimientoRepo $TipoDeMovimientoRepo)
  {
    $this->TipoDeMovimientoRepo = $TipoDeMovimientoRepo;
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
}