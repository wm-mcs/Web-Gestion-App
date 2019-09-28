<?php 

namespace App\Repositorios;

use App\Entidades\SucursalEmpresa;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

/**
* Repositorio de consultas a la base de datos User
*/
class SucursalEmpresaRepo extends BaseRepo
{
  
  public function getEntidad()
  {
    return new SucursalEmpresa();
  }


 


  
}