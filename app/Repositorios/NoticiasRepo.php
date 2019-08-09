<?php 

namespace App\Repositorios;

use App\Entidades\Noticia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

/**
* Repositorio de consultas a la base de datos User
*/
class NoticiasRepo extends BaseRepo
{
  
  public function getEntidad()
  {
    return new Noticia();
  }

  //guetters/////////////////////////////////////////////////////////////////////




  //setters//////////////////////////////////////////////////////////////////////

  


  
}