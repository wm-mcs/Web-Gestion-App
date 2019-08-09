<?php 

namespace App\Repositorios;

use App\Entidades\ProductoImg;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

/**
* Repositorio de consultas a la base de datos User
*/
class ProductoImgRepo extends BaseRepo
{
  
  public function getEntidad()
  {
    return new ProductoImg();
  }


  public function cambio_a_imagen_principal($id_img)
  {
    $imagen = $this->find($id_img);

    $imagen_pricipal = $this->get_imagen_principal_de_entidad_especifica('producto_id',$imagen->producto_id) ;  

    $this->cambio_a_imagen_principal_desde_base_repo($imagen_pricipal,$imagen);
  }
}