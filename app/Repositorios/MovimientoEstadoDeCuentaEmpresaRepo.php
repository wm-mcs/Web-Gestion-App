<?php 

namespace App\Repositorios;

use App\Entidades\MovimientoEstadoDeCuentaEmpresa;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

/**
* Repositorio de consultas a la base de datos User
*/
class MovimientoEstadoDeCuentaEmpresaRepo extends BaseRepo
{
  
  public function getEntidad()
  {
    return new MovimientoEstadoDeCuentaEmpresa();
  }

  //Cuando agrego un servicio nuevo creo estado de cuenta
  public function setEstadoDeCuentaCuando($Empresa_id,$User_id,$Moneda,$Valor,$Detalle,$Tipo_saldo,$Fecha,$Servicio_id)
  {
    $Entidad = $this->getEntidad();

    $Entidad->empresa_id    = $Empresa_id;
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

        $Movimeinto_anulador->empresa_id            = $MovimientoAAnular->empresa_id;
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