<?php 

namespace App\Repositorios;

use App\Entidades\HomeWeb;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

/**
* Repositorio de consultas a la base de datos User
*/
class HomeWebRepo extends BaseRepo
{
  
  public function getEntidad()
  {
    return new HomeWeb();
  }


  public function getHomeWebDatos()
  {
     return $this->getEntidad()->find(1);
  }

  public function setDatos($request)
  {
    $HomeDatos = $this->getHomeWebDatos();

    $Propiedades = ['seccion_1_titulo','seccion_1_descripcion','seccion_2_titulo','seccion_2_descripcion','seccion_3_titulo','seccion_3_descripcion','seccion_4_titulo','seccion_4_descripcion'];
    
    $this->setEntidadDato($HomeDatos,$request,$Propiedades);   

    $HomeDatos->save();   
  }
}