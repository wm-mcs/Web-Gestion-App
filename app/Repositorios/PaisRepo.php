<?php 

namespace App\Repositorios;

use App\Entidades\Pais;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

/**
* Repositorio de consultas a la base de datos User
*/
class PaisRepo extends BaseRepo
{
  
  public function getEntidad()
  {
    return new Pais();
  }

   
  


 
}