<?php 

namespace App\Repositorios;

use App\Entidades\ServicioContratadoSocio;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

/**
* Repositorio de consultas a la base de datos User
*/
class ServicioContratadoSocioRepo extends BaseRepo
{
  
  public function getEntidad()
  {
    return new ServicioContratadoSocio();
  }

  //guetters/////////////////////////////////////////////////////////////////////

  


  //setters//////////////////////////////////////////////////////////////////////

 
  public function getServiciosContratadosASocios($socio_id)
  {
    return $this->getEntidad()
                ->where('socio_id',$socio_id)
                ->where('estado','si')
                ->orderBy('fecha_vencimiento','desc')
                ->get();
  }
 


  
}