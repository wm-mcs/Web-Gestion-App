<?php 

namespace App\Repositorios;

use App\Entidades\ImgHome;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

/**
* Repositorio de consultas a la base de datos User
*/
class ImgHomeRepo extends BaseRepo
{
  
  public function getEntidad()
  {
    return new ImgHome();
  }


  

  public function setDatos($request)
  {
    $ImgHome = $this->getEntidad();

    $Propiedades = ['img','name','description','url'];
    
    $this->setEntidadDato($ImgHome,$request,$Propiedades); 

    $ImgHome->home_id = 1;
    $ImgHome->estado  = 'si';

    $ImgHome->save();

    $this->setImagen($ImgHome,$request,'img','HomeImagenes/', $ImgHome->name,'.png');  

    $ImgHome->save();   
  }


   public function setAdminEdit($img,$request)
  {
    
    //propiedades para crear
    $Propiedades =  ['img','name','description','url','estado'];

    $this->setEntidadDato($img,$request,$Propiedades);

    $img->save();

    $this->setImagen($img,$request,'img','HomeImagenes/', $img->name,'.png');  

    $img->save();

  }
}