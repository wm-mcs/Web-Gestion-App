<?php 

namespace App\Repositorios;

use App\Entidades\EmpresaConSocios;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

/**
* Repositorio de consultas a la base de datos User
*/
class EmpresaConSociosoRepo extends BaseRepo
{
  
  public function getEntidad()
  {
    return new EmpresaConSocios();
  }

   
  


}