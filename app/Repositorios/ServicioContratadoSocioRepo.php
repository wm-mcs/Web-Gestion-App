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
                ->where('borrado','no')
                ->orderBy('fecha_vencimiento','desc')
                ->get();
  }


  public function getServiciosDeEsteSocioYConEsteTipoId($socio_id,$Tipo_id)
  {
    $servicios = $this->getEntidad()
                ->where('socio_id',$socio_id)
                ->where('estado','si')
                ->where('borrado','no')
                ->where('tipo_servicio_id',$Tipo_id)
                ->orderBy('fecha_vencimiento','desc')
                ->get();
    dd($servicios,$servicios->first() );
                return $servicios->first();
  }


  public function setServicioASocio($Socio_id,$Scuursal_id,$Tipo_de_servicio_objeto,$Fecha_vencimiento)
  {
    $Entidad = $this->getEntidad();
    $Entidad->estado             = 'si';
    $Entidad->borrado            = 'no';
    $Entidad->esta_consumido     = 'no';
    $Entidad->sucursal_emitio_id = $Scuursal_id;
    $Entidad->socio_id           = $Socio_id;
    $Entidad->tipo_servicio_id   = $Tipo_de_servicio_objeto->id;
    $Entidad->tipo               = $Tipo_de_servicio_objeto->tipo;
    $Entidad->name               = $Tipo_de_servicio_objeto->name;
    $Entidad->valorvalor         = $Tipo_de_servicio_objeto->valor;
    $Entidad->moneda             = $Tipo_de_servicio_objeto->moneda;
    $Entidad->fecha_vencimiento  = $Fecha_vencimiento;
    $Entidad->save();

    return $Entidad;
  }
 


  
}