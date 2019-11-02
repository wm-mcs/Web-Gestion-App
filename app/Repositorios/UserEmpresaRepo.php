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




  public function setAsociarEmpresaYUser($Empresa_id,$User_id,$Gerarqui,$User,$Sucursal_id)
  {


    if($User->role >= $Gerarqui)
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
          
          $Entidad              = $this->getEntidad();
          $Entidad->user_id     = $User_id;
          $Entidad->empresa_id  = $Empresa_id;

          if($Sucursal_id != null){
          $Entidad->sucursal_id = $Sucursal_id;
          }
          
          $Entidad->save();
        }


        return [  
                 'Validacion'          =>  $Validacion,
                 'Validacion_mensaje'  =>  $Mensaje     
               ];


    }	
    else
    {
       return [  
                 'Validacion'          =>  false,
                 'Validacion_mensaje'  =>  'Ese usuario no tiene la gerarquia necesaría para vincular como tal'     
               ];
    }

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
      else
      {
          $Validacion = false;
      }


      return [  
             'Validacion'   =>  $Validacion,
             'UserEmpresa'  =>  $User->first()   
               ];
  }

  public function getEmpresasDeEsteUsuario($UserId)
  {
    $empresas =  $this->getEntidad()
                      ->where('user_id',$UserId)
                      ->get();
    $array_id = [];

    
    
    foreach ($empresas as $empresa) 
    {
            array_push($array_id,$empresa->empresa_id);
    }   

    return $array_id;               
  }


 


  
}