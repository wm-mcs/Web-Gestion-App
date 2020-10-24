<?php 

namespace App\Repositorios;

use App\Entidades\MovimientoPadre;


class MovimientoPadreRepo extends BaseRepo
{  
  public function getEntidad()
  {
    return new MovimientoPadre();
  }
 
}