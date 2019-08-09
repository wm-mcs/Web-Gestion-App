<?php 

namespace App\Repositorios;

use App\Entidades\Proyecto;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

/**
* Repositorio de consultas a la base de datos User
*/
class ProyectoRepo extends BaseRepo
{
  
  public function getEntidad()
  {
    return new Proyecto();
  }



 
  

  
}