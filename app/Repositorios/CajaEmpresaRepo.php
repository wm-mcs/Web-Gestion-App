<?php 

namespace App\Repositorios;

use App\Entidades\CajaEmpresa;
use Illuminate\Support\Facades\Cache;
use App\Helpers\Traits\contabilidadTrait;




class CajaEmpresaRepo extends BaseRepo
{
  

  use contabilidadTrait;
  
  public function getEntidad()
  {
    return new CajaEmpresa();
  }


  /**
   * Me trae el movimiento de caja asocioado al movimiento de estado de cuenta
   * Si no encuentra devuelve null
   * 
   * @return Object Caja or null si no encuentra
   * */  
  public function getMovimientosDeCajaSegunEstadoDecuentasocioID($MovimientoEstadoDeCuentaSocioID)
  {
    $MovimientosDeCaja = $this->getEntidad()
                              ->where('estado_de_cuenta_del_socio_id',$MovimientoEstadoDeCuentaSocioID) 
                              ->get();
    if($MovimientosDeCaja->count() > 0)
    {
      return $MovimientosDeCaja->first();
    }     
    
    return null;
  }

  /**
   * Busca si hay un movimiento de caja con ese id de estado de cuenta
   * Si encuentra devuelve el id del movimiento de caja de lo contrario null
   * 
   * 
   */
  public function getTipoDeMovimientoIDPasandoEstadoDeCuentaSocioID($MovimientoEstadoDeCuentaSocioID)
  {
    if($this->getMovimientosDeCajaSegunEstadoDecuentasocioID($MovimientoEstadoDeCuentaSocioID) != null)
    {
      return $this->getMovimientosDeCajaSegunEstadoDecuentasocioID($MovimientoEstadoDeCuentaSocioID)->tipo_de_movimiento_id;
    }

    return null;
  }

  public function getMovimientosDeCajaDeEstaEmpresa($empresa_id)
  {
    return $this->getEntidad()
                ->where('empresa_id',$empresa_id)
                ->where('borrado','no')
                ->get();
  }

  public function InresarMovimientoDeCaja($empresa_id,
                                          $sucursal_id,
                                          $user_id,
                                          $tipo_saldo,
                                          $moneda,
                                          $valor,
                                          $detalle,
                                          $fecha_ingreso,
                                          $tipo_movimiento,
                                          $servicio = null,
                                          $tipo_de_movimiento_id = null,
                                          $estado_de_cuenta_del_socio_id = null)
  {
    $Entidad                   = $this->getEntidad();
    $Entidad->empresa_id       = $empresa_id;
    $Entidad->sucursal_id      = $sucursal_id; 
    $Entidad->user_id          = $user_id;
    $Entidad->tipo_saldo       = $tipo_saldo;
    $Entidad->moneda           = $moneda;
    $Entidad->valor            = $valor;
    $Entidad->detalle          = $detalle;
    $Entidad->tipo_movimiento  = $tipo_movimiento;
    $Entidad->fecha_ingreso    = $fecha_ingreso;
    $Entidad->borrado          = 'no';

    if($servicio != null)
    {
      $Entidad->servicio_id = $servicio->id;
    }

    if($tipo_de_movimiento_id != null)
    {
      $Entidad->tipo_de_movimiento_id = $tipo_de_movimiento_id;
    }

    if($estado_de_cuenta_del_socio_id != null)
    {
      $Entidad->estado_de_cuenta_del_socio_id = $estado_de_cuenta_del_socio_id;
    }

    $Entidad->save();

    //actualizoElCache de todo lo que tiene que ver con Caja
    $this->ActualizarCache($sucursal_id);

    return $Entidad;

  }


  public function getMovimeintosDeEstaSecursalYServicio($servicio_id,$sucursal_id)
  {
    return $this->getEntidad()
                ->where('servicio_id',$servicio_id)  
                ->where('sucursal_id',$sucursal_id )
                ->get();
  }

  public function getMovimientosDeEstaSucrsal($sucursal_id)
  {
    return $this->getEntidad()->where('sucursal_id',$sucursal_id)
                              ->where('borrado','no')
                              ->orderBy('fecha_ingreso', 'DESC')
                              ->get();
  }

  public function getMovimientoYSaldoEntreFechas($sucursal_id,$Moneda,$Fecha_inicio = null, $Fecha_fin =  null)
  {
        $Movimientos = $this->getEntidad()
                            ->where('sucursal_id',$sucursal_id)
                            ->where('borrado','no')
                            ->where('moneda',$Moneda)
                            ->whereBetween('fecha_ingreso',[$Fecha_inicio,$Fecha_fin])
                            
                            ->orderBy('fecha_ingreso', 'DESC')
                            ->get();

        
      

        $Saldo = $this->getSaldoSegunMonedaYFechaFin($sucursal_id,$Moneda,$Fecha_fin);  

      return [
              'Movimientos' => $Movimientos,
              'Saldo'       => $Saldo
             ];


  }

  public function getSaldoSegunMonedaYFechaFin($sucursal_id,$Moneda,$Fecha_fin)
  {
    $Movimientos = $this->getEntidad()
                        ->where('sucursal_id',$sucursal_id)
                        ->where('borrado','no')
                        ->where('moneda',$Moneda)
                        ->where('fecha_ingreso','<',$Fecha_fin)
                        
                        ->get();


      $Debe    = $Movimientos->where('tipo_saldo','deudor')          
                             ->sum('valor');

      $Acredor = $Movimientos->where('tipo_saldo','acredor') 
                             ->sum('valor');


      return round($Debe - $Acredor) ;  
  }


  public function getSaldoDeEstaSucursalEnPesos($sucursal_id)
  {
      $Debe    = $this->getMovimientosDeEstaSucrsalEnPesos($sucursal_id)->where('tipo_saldo','deudor')          
                                                                ->sum('valor');

      $Acredor = $this->getMovimientosDeEstaSucrsalEnPesos($sucursal_id)->where('tipo_saldo','acredor') 
                                                                ->sum('valor');


      return round($Debe - $Acredor) ;  
  }

  public function getSaldoDeEstaSucursalEnDolares($sucursal_id)
  {
      $Debe    = $this->getMovimientosDeEstaSucrsalEnDolares($sucursal_id)->where('tipo_saldo','deudor')          
                                                                  ->sum('valor');

      $Acredor = $this->getMovimientosDeEstaSucrsalEnDolares($sucursal_id)->where('tipo_saldo','acredor') 
                                                                  ->sum('valor');
                                                                  
      return round($Debe - $Acredor) ; 
  }


 

  public function getMovimientosDeEstaSucrsalEnPesos($sucursal_id)
  {
    return $this->getEntidad()->where('sucursal_id',$sucursal_id)
                              ->where('borrado','no')
                              ->where('moneda','$')
                              ->orderBy('fecha_ingreso', 'DESC')
                              ->get();
  }

  public function getMovimientosDeEstaSucrsalEnDolares($sucursal_id)
  {
    return $this->getEntidad()->where('sucursal_id',$sucursal_id)
                              ->where('borrado','no')
                              ->where('moneda','U$S')
                              ->orderBy('fecha_ingreso', 'DESC')
                              ->get();
  }



  public function ActualizarCache($sucursal_id)
  {
    $Array_cache = [/*
                      'MovimientosCajaSucursal'.$sucursal_id, 
                      'MovimientosCajaDolaresSucursal'.$sucursal_id,
                      'MovimientosCajaPesosSucursal'.$sucursal_id,*/
                      'SaldoCajaPesosSucursal'.$sucursal_id,
                      'SaldoCajaDolaresSucursal'.$sucursal_id     
                  ];

    foreach ($Array_cache as $cache )
    {
      if (Cache::has($cache))
      {
       Cache::forget($cache);
      }
    } 

/*   $MovimientosCajaSucursal =  $this->getMovimientosDeEstaSucrsal($sucursal_id);
   Cache::remember('MovimientosCajaSucursal'.$sucursal_id, 120, function() use ($MovimientosCajaSucursal){
        return  $MovimientosCajaSucursal ;
   });    

   $MovimientosCajaSucursal =  $this->getMovimientosDeEstaSucrsalEnDolares($sucursal_id) ;
   Cache::remember('MovimientosCajaDolaresSucursal'.$sucursal_id, 120, function() use ($MovimientosCajaSucursal){
        return  $MovimientosCajaSucursal ;
   });    

   $MovimientosCajaPesosSucursal = $this->getMovimientosDeEstaSucrsalEnPesos($sucursal_id);
   Cache::remember('MovimientosCajaPesosSucursal'.$sucursal_id, 120, function() use ($MovimientosCajaPesosSucursal){
        return  $MovimientosCajaPesosSucursal ;
   });   */

   $SaldoCajaPesosSucursal =  $this->getSaldoDeEstaSucursalEnPesos($sucursal_id);
   Cache::remember('SaldoCajaPesosSucursal'.$sucursal_id, 120, function() use ($SaldoCajaPesosSucursal){
        return  $SaldoCajaPesosSucursal ;
   });  

   $SaldoCajaDolaresSucursal = $this->getSaldoDeEstaSucursalEnDolares($sucursal_id);
    Cache::remember('SaldoCajaDolaresSucursal'.$sucursal_id, 120, function() use ($SaldoCajaDolaresSucursal){
        return  $SaldoCajaDolaresSucursal ;
   });       
    
  }








  

 


 


  
}