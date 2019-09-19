<?php 

namespace App\Repositorios;

use App\Entidades\CajaEmpresa;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

/**
* Repositorio de consultas a la base de datos User
*/
class CajaEmpresaRepo extends BaseRepo
{
  
  public function getEntidad()
  {
    return new CajaEmpresa();
  }


 


  
}