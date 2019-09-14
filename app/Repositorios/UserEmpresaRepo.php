<?php 

namespace App\Repositorios;

use App\Entidades\UserEmpresa;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

/**
* Repositorio de consultas a la base de datos User
*/
class UserEmpresaRepo extends BaseRepo
{
  
  public function getEntidad()
  {
    return new UserEmpresa();
  }


 


  
}