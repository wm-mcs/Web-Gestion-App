<?php 

namespace App\Repositorios;

use App\Entidades\MovimientoPadreDeEmpresa;


class MovimientoPadreDeEmpresaRepo extends BaseRepo
{

  
  public function getEntidad()
  {
    return new MovimientoPadreDeEmpresa();
  }  


}