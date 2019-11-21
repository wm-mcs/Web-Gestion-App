<?php 

namespace App\Repositorios;

use App\Entidades\EmpresaConSocios;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

/**
* Repositorio de consultas a la base de datos User
*/
class EmpresaConSociosoRepo extends BaseRepo
{
  
  public function getEntidad()
  {
    return new EmpresaConSocios();
  }



  public function CrearEmpresaComoVendedor($nombre,$email,$celular,$factura_con_iva,$rut,$razon_social)
  {
    $Entidad = $this->getEntidad();

    $Entidad->name            = $nombre ;
    $Entidad->email           = $email;
    $Entidad->celular         = $celular;
    $Entidad->factura_con_iva = $factura_con_iva;
    $Entidad->rut             = $rut;
    $Entidad->razon_social    = $razon_social; 
    $Entidad->save();
    return $Entidad;
  }


  

   
  


}