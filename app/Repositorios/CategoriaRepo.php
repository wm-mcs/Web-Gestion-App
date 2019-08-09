<?php 

namespace App\Repositorios;

use App\Entidades\Categoria;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

/**
* Repositorio de consultas a la base de datos User
*/
class CategoriaRepo extends BaseRepo
{
  
  public function getEntidad()
  {
    return new Categoria();
  }


 


  
}