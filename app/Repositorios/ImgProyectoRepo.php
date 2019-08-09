<?php 

namespace App\Repositorios;

use App\Entidades\ImgProyecto;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

/**
* Repositorio de consultas a la base de datos User
*/
class ImgProyectoRepo extends BaseRepo
{
  
  public function getEntidad()
  {
    return new ImgProyecto();
  }

   
  


  public function cambio_a_imagen_principal($id_img)
  {
    $imagen = $this->find($id_img);

    $imagen_pricipal = $this->get_imagen_principal_de_entidad_especifica('proyecto_id',$imagen->proyecto_id) ;  

    $this->cambio_a_imagen_principal_desde_base_repo($imagen_pricipal,$imagen);
  }
}