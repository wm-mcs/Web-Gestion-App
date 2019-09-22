<?php 

namespace App\Repositorios;

use App\Entidades\VendedorEmpresa;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

/**
* Repositorio de consultas a la base de datos User
*/
class VendedorEmpresaRepo extends BaseRepo
{
  
  public function getEntidad()
  {
    return new VendedorEmpresa();
  }



  public function setAsociarEmpresaYUser($Empresa_id,$User_id)
  {

    $Existe = $this->getEntidad()
                   ->where('user_id',$User_id)
                   ->where('empresa_id',$Empresa_id)
                   ->get();

    $Validator = $this->verificarSiUserYEmpresaEstanVicnulados($User_id,$Empresa_id);

    $Validacion = $Validator['Validacion'];
    $Mensaje    = $Validator['Mensaje'];

    if($Validacion)
    {      
      $Entidad             = $this->getEntidad();
      $Entidad->user_id    = $User_id;
      $Entidad->empresa_id = $Empresa_id;
      $Entidad->save();
    }


    return [  
             'Validacion'          =>  $Validacion,
             'Validacion_mensaje'  =>  $Mensaje     
           ];


  	

  }


  public function verificarSiUserYEmpresaEstanVicnulados($User_id,$Empresa_id)
  {
      $User = $this->getEntidad()
                   ->where('user_id',$User_id)
                   ->where('empresa_id',$Empresa_id)
                   ->get(); 

      $User_de_empresa = $this->getEntidad()                             
                              ->where('empresa_id',$Empresa_id)
                              ->get(); 

      $Validacion = true;  
      $Mensaje    = 'Vendedor asignado correctamente';

      if($User_de_empresa->count() > 0)
      {
          $Validacion = false;
          $Mensaje    = 'Ya tiene un vendedor asignado';
      }           

      if($User->count() > 0)
      {
          $Validacion = false;
      }

     


      return [  
             'Validacion'   =>  $Validacion,
             'UserEmpresa'  =>  $User->first(),
             'Mensaje'      =>  $Mensaje   
               ];
  }


 


  
}