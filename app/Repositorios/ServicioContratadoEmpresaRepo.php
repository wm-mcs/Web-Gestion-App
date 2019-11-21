<?php 

namespace App\Repositorios;

use App\Entidades\ServicioContratadoEmpresa;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

/**
* Repositorio de consultas a la base de datos User
*/
class ServicioContratadoEmpresaRepo extends BaseRepo
{
  
  public function getEntidad()
  {
    return new ServicioContratadoEmpresa();
  }

  //guetters/////////////////////////////////////////////////////////////////////

  


  //setters//////////////////////////////////////////////////////////////////////

  public function setServicioAEmpresa($Empresa,$Servicio,$Fecha_vencimiento)
  {
    $Entidad                    = $this->getEntidad();
    $Entidad->empresa_id        = $Empresa->id;
    $Entidad->name              = $Servicio->name;
    $Entidad->moneda            = $Servicio->moneda;
    $Entidad->valor             = $this->getValorSiEsConIVAONO($Empresa->factura_con_iva, $Servicio->valor);
    $Entidad->tipo_servicio_id  = $Servicio->id;
    $Entidad->fecha_vencimiento = $Fecha_vencimiento;

    return $Entidad;
  }

 


  
}