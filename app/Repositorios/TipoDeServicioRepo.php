<?php 

namespace App\Repositorios;

use App\Entidades\TipoDeServicio;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

/**
* Repositorio de consultas a la base de datos User
*/
class TipoDeServicioRepo extends BaseRepo
{
  
  public function getEntidad()
  {
    return new TipoDeServicio();
  }

  //guetters/////////////////////////////////////////////////////////////////////

  
  public function getServiciosActivosDeEmpresa($Empresa_id)
  {
    return $this->getEntidad()->where('empresa_id',$Empresa_id)->active()->get();
  }

  //setters//////////////////////////////////////////////////////////////////////

 

 


  
}