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



  public function setAsociarEmpresaYUser($Empresa_id,$User_id)
  {
  	$Entidad             = $this->getEntidad();
  	$Entidad->user_id    = $User_id;
  	$Entidad->empresa_id = $Empresa_id;
  	$Entidad->save();

  }


 


  
}