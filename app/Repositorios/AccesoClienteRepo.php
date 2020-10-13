<?php 

namespace App\Repositorios;

use App\Entidades\AccesoCliente;
use Illuminate\Support\Facades\Cache;



class AccesoClienteRepo extends BaseRepo
{  
  
  public function getEntidad()
  {
    return new AccesoCliente();
  }


  public function setAcceso($Empresa_id,$Sucursal_id,$Socio,$Celular,$Fecha)
  {
      $Acceso = $this->getEntidad();
      $Acceso->empresa_id  = $Empresa_id;
      $Acceso->sucursal_id = $Sucursal_id;
      $Acceso->socio_id    = $Socio->id; 
      $Acceso->name        = $Socio->name; 
      $Acceso->celular     = $Celular; 
      $Acceso->fecha       = $Fecha; 
      $Acceso->save();           
  }

  
    

   
  


 
}