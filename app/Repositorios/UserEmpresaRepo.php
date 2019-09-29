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


  public function getUsuariosDeEstaEmpresa($Empresa_id)
  {
    return $this->getEntidad()->where('empresa_id',$Empresa_id )->get();
  } 




  public function setAsociarEmpresaYUser($Empresa_id,$User_id)
  {

    $Existe = $this->getEntidad()
                   ->where('user_id',$User_id)
                   ->where('empresa_id',$Empresa_id)
                   ->get();

    $Validacion = false;
    $Mensaje    = 'Ya está asociado este usuario con está empresa';

    if($Existe->count() == 0)
    {
      $Validacion = true;
      $Mensaje    = 'Se asoció correctamente';
      
      $Entidad             = $this->getEntidad();
      $Entidad->user_id    = $User_id;
      $Entidad->empresa_id = $Empresa_id;
      $Entidad->save();
    }


    return [  
             'Validacion'          =>  $Validacion,
             'Validacion_mensaje'  =>  $Mensaje,
             'User'                =>  $Entidad->usuario     
           ];


  	

  }


  public function verificarSiUserYEmpresaEstanVicnulados($User_id,$Empresa_id)
  {
      $User = $this->getEntidad()
                   ->where('user_id',$User_id)
                   ->where('empresa_id',$Empresa_id)
                   ->get(); 

      $Validacion = false;             

      if($User->count() > 0)
      {
          $Validacion = true;
      }


      return [  
             'Validacion'   =>  $Validacion,
             'UserEmpresa'  =>  $User->first()   
               ];
  }


 


  
}