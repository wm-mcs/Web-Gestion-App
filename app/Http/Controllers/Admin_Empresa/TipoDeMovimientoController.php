<?php

namespace App\Http\Controllers\Admin_Empresa;
use Illuminate\Http\Request;
use App\Repositorios\TipoDeMovimientoRepo;




class TipoDeMovimientoController 
{
  protected $TipoDeMovimientoRepo;

  public function __construct(TipoDeMovimientoRepo $TipoDeMovimientoRepo)
  {
    $this->TipoDeMovimientoRepo = $TipoDeMovimientoRepo;
  }


  public function getIndex()
  {
    return view('empresa_gestion_paginas.Administrador.tipo_de_movimientos');
  }
}