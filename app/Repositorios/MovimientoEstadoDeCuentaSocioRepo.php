<?php 

namespace App\Repositorios;

use App\Entidades\MovimientoEstadoDeCuentaSocio;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

/**
* Repositorio de consultas a la base de datos User
*/
class MovimientoEstadoDeCuentaSocioRepo extends BaseRepo
{
  
  public function getEntidad()
  {
    return new MovimientoEstadoDeCuentaSocio();
  }

  //guetters/////////////////////////////////////////////////////////////////////


  public function getEstadoDeCuentasDelSocio($socio_id)
  {
    return $this->getEntidad()
                ->where('socio_id',$socio_id)
                ->orderBy('fecha_ingreso', 'desc')
                ->get();
  }

  public function getEstadoDeCuentasDelSocioDeUnServicioEnParticular($socio_id,$servicio_id)
  {
    return $this->getEntidad()
                ->where('socio_id',$socio_id)
                ->where('servicio_id',$servicio_id)                
                ->get();
  }

  
  //Cuando agrego un servicio nuevo creo estado de cuenta
  public function setEstadoDeCuentaCuando($Socio_id,$Moneda,$Valor,$Detalle,$Tipo_saldo,$Fecha,$Servicio_id)
  {
    $Entidad = $this->getEntidad();

    $Entidad->socio_id      = $Socio_id;
    $Entidad->tipo_saldo    = $Tipo_saldo;
    $Entidad->moneda        = $Moneda;
    $Entidad->valor         = $Valor;
    $Entidad->detalle       = $Detalle;
    $Entidad->fecha_ingreso = $Fecha;
    $Entidad->servicio_id   = $Servicio_id;

    $Entidad->save();

  }

  //setters//////////////////////////////////////////////////////////////////////

 

 


  
}