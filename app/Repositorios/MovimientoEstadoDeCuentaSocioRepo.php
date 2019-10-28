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
                ->where('borrado','no')
                ->get();
  }

  public function getEstadoDeCuentasDelSocioDeUnServicioEnParticular($socio_id,$servicio_id)
  {
    return $this->getEntidad()
                ->where('socio_id',$socio_id)
                ->where('servicio_id',$servicio_id)    
                ->where('borrado','no')            
                ->get();
  }

  
  //Cuando agrego un servicio nuevo creo estado de cuenta
  public function setEstadoDeCuentaCuando($Socio_id,$User_id,$Moneda,$Valor,$Detalle,$Tipo_saldo,$Fecha,$Servicio_id)
  {
    $Entidad = $this->getEntidad();

    $Entidad->socio_id      = $Socio_id;
    $Entidad->user_id       = $User_id;
    $Entidad->tipo_saldo    = $Tipo_saldo;
    $Entidad->moneda        = $Moneda;
    $Entidad->valor         = $Valor;
    $Entidad->detalle       = $Detalle;
    $Entidad->fecha_ingreso = $Fecha;
    $Entidad->servicio_id   = $Servicio_id;

   
    

    $Entidad->save();

  }

  //setters//////////////////////////////////////////////////////////////////////
  public function AnularEsteEstadoDeCuenta($MovimientoAAnular,$User_id,$Fecha)
  {

    if($MovimientoAAnular->estado_del_movimiento != 'anulado'  && $MovimientoAAnular->estado_del_movimiento != 'anulador' )
    {
        //indico que se anuló
        $this->setAtributoEspecifico($MovimientoAAnular,'estado_del_movimiento','anulado');

        //creo el movimiento opuesto
        $Saldo   = $this->DevolverTipoDeSaldoOpuesto($MovimientoAAnular->tipo_saldo);
        $Detalle = $this->getDetalleAlAnular($MovimientoAAnular);

        $Movimeinto_anulador = $this->getEntidad();

        $Movimeinto_anulador->socio_id              = $MovimientoAAnular->socio_id;
        $Movimeinto_anulador->user_id               = $MovimientoAAnular->user_id;
        $Movimeinto_anulador->tipo_saldo            = $Saldo;
        $Movimeinto_anulador->moneda                = $MovimientoAAnular->moneda;
        $Movimeinto_anulador->valor                 = $MovimientoAAnular->valor;
        $Movimeinto_anulador->detalle               = $Detalle;
        $Movimeinto_anulador->fecha_ingreso         = $Fecha;
        $Movimeinto_anulador->servicio_id           = $MovimientoAAnular->servicio_id;
        $Movimeinto_anulador->estado_del_movimiento = 'anulador';
        $Movimeinto_anulador->save();
   }
}
 

 


  
}