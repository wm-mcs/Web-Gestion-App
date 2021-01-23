<?php 

namespace App\Repositorios;

use App\Entidades\MovimientoEstadoDeCuentaEmpresa;
use Illuminate\Support\Facades\Cache;
use App\Helpers\Traits\contabilidadTrait;


class MovimientoEstadoDeCuentaEmpresaRepo extends BaseRepo
{

  use contabilidadTrait;
  
  public function getEntidad()
  {
    return new MovimientoEstadoDeCuentaEmpresa();
  }

  
  /**
   * Crea un nuevo estado de cuenta
   *
   * @return void
   */
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

    $this->ActualizarCache( $Empresa_id);
  }

  /**
   * Anula el estado de cuenta
   *
   * @return void
   */
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

        $this->ActualizarCache($MovimientoAAnular->empresa_id);
   }
}


/**
 * Me todos los movimientos sin borra de esta empres
 *
 * @return array 
 */
public function getMovimientosDeEstadoDeCuenta($empresa_id)
{
  return $this->getEntidad()
              ->where('empresa_id',$empresa_id)
              ->where('borrado','no') 
              ->orderBy('fecha_ingreso', 'desc')
              ->get();
} 

/**
 * Me trae los estado de cuenta de este servicio
 *
 * @return void
 */
public function getMovimientosDeEstadoDeCuentaDeEsteServicio($empresa_id,$servicio_id)
{
  return $this->getEntidad()
              ->where('empresa_id',$empresa_id)
              ->where('servicio_id',$servicio_id)
              ->where('borrado','no') 
              ->orderBy('fecha_ingreso', 'desc')
              ->get();
} 


public function getSaldoEnPesosDeEstaEmpresa($empresa_id)
{
  $Debe    = $this->getMovimientosDeEstadoDeCuenta($empresa_id)->where('tipo_saldo','deudor')
                                                 ->where('moneda','$')                      
                                                 ->sum('valor');

  $Acredor = $this->getMovimientosDeEstadoDeCuenta($empresa_id)->where('tipo_saldo','acredor')          
                                                 ->where('moneda','$')
                                                 ->sum('valor');

  return round($Debe - $Acredor) ; 
}

public function getSaldoEnDolaresDeEstaEmpresa($empresa_id)
{
  $Debe    = $this->getMovimientosDeEstadoDeCuenta($empresa_id)->where('tipo_saldo','deudor')
                                                               ->where('moneda','U$S')
                                                               ->sum('valor');

  $Acredor = $this->getMovimientosDeEstadoDeCuenta($empresa_id)->where('tipo_saldo','acredor')        
                                                               ->where('moneda','U$S')
                                                               ->sum('valor');

  return round($Debe - $Acredor) ; 
}


/**
 * Borra los caché que la entidad y lo cambia por le nuevo
 *
 * @return void
 */
public function ActualizarCache($empresa_id)
{
    $Array_cache = [
                    'MovimeintosEstadoDeCuentaEmpresa'.$empresa_id, 
                    'SaldoPesosEmpresa'.$empresa_id,
                    'SaldoDoalresEmpresa'.$empresa_id
                   ];

    foreach ($Array_cache as $cache )
    {
      if (Cache::has($cache))
      {
       Cache::forget($cache);
      }
    } 

   $EstadoDeCuentas =  $this->getMovimientosDeEstadoDeCuenta($empresa_id);
          Cache::remember('MovimeintosEstadoDeCuentaEmpresa'.$empresa_id, 8000, function() use ($EstadoDeCuentas){
        return  $EstadoDeCuentas ;
   }); 

   $SaldoPesos =  $this->getSaldoEnPesosDeEstaEmpresa($empresa_id);
   Cache::remember('SaldoPesosEmpresa'.$empresa_id, 8000, function() use ($SaldoPesos){
        return  $SaldoPesos ;
   }); 

   $SaldoDolares =  $this->getSaldoEnDolaresDeEstaEmpresa($empresa_id);
   Cache::remember('SaldoDoalresEmpresa'.$empresa_id, 8000, function() use ($SaldoDolares){
        return  $SaldoDolares ;
   }); 
   
}

 

 


  
}