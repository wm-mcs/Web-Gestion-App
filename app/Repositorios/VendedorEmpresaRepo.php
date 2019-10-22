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


  public function getVendedoresDeEstaEmpresa($Empresa_id)
  {
    return  $this->getEntidad()->where('empresa_id',$Empresa_id )->get();
  }

  public function setAsociarEmpresaYVendedor($Empresa_id,$User_id,$Gerarqui,$User)
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

  public function getEmpresasDeEsteVendedor($UserId)
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