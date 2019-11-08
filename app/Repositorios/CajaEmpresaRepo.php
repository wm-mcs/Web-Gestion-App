<?php 

namespace App\Repositorios;

use App\Entidades\CajaEmpresa;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;



/**
* Repositorio de consultas a la base de datos User
*/
class CajaEmpresaRepo extends BaseRepo
{
  
  public function getEntidad()
  {
    return new CajaEmpresa();
  }


  


  public function InresarMovimientoDeCaja($empresa_id,$sucursal_id,$user_id,$tipo_saldo,$moneda,$valor,$detalle,$fecha_ingreso,$tipo_movimiento,$servicio = null)
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

    if($servicio != null)
    {
      $Entidad->servicio_id = $servicio->id;
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
                              ->orderBy('created_at', 'DESC');
  }


  public function getSaldoDeEstaSucursalEnPesos($sucursal_id)
  {
      $Debe    = $this->getMovimientosDeEstaSucrsalEnPesos->where('tipo_saldo','deudor')          
                                                                ->sum('valor');

      $Acredor = $this->getMovimientosDeEstaSucrsalEnPesos->where('tipo_saldo','acredor') 
                                                                ->sum('valor');


      return round($Debe - $Acredor) ;  
  }

  public function getSaldoDeEstaSucursalEnDolares($sucursal_id)
  {
      $Debe    = $this->getMovimientosDeEstaSucrsalEnDolares->where('tipo_saldo','deudor')          
                                                                  ->sum('valor');

      $Acredor = $this->getMovimientosDeEstaSucrsalEnDolares->where('tipo_saldo','acredor') 
                                                                  ->sum('valor');


      return round($Debe - $Acredor) ; 
  }


 

  public function getMovimientosDeEstaSucrsalEnPesos($sucursal_id)
  {
    return $this->getEntidad()->where('sucursal_id',$sucursal_id)
                              ->where('borrado','no')
                              ->where('moneda','$')
                              ->orderBy('created_at', 'DESC');
  }

  public function getMovimientosDeEstaSucrsalEnDolares($sucursal_id)
  {
    return $this->getEntidad()->where('sucursal_id',$sucursal_id)
                              ->where('borrado','no')
                              ->where('moneda','U$S')
                              ->orderBy('created_at', 'DESC');
  }



  public function ActualizarCache($sucursal_id)
  {
    $Array_cache = [
                      'MovimientosCajaSucursal'.$sucursal_id, 
                      'MovimientosCajaDolaresSucursal'.$sucursal_id,
                      'MovimientosCajaPesosSucursal'.$sucursal_id,
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

   $MovimientosCajaSucursal =  $this->getMovimientosDeEstaSucrsal($sucursal_id);
   Cache::remember('MovimientosCajaSucursal'.$sucursal_id, 120, function() use ($MovimientosCajaSucursal){
        return  $MovimientosCajaSucursal ;
   });    

   $MovimientosCajaSucursal =  $this->getMovimientosDeEstaSucrsalEnDolares($sucursal_id) ;
   Cache::remember('MovimientosCajaDolaresSucursal'.$sucursal_id, 120, function() use ($sucursal_id){
        return  $MovimientosCajaSucursal ;
   });    

   $MovimientosCajaPesosSucursal = $this->getMovimientosDeEstaSucrsalEnPesos($sucursal_id);
   Cache::remember('MovimientosCajaPesosSucursal'.$sucursal_id, 120, function() use ($MovimientosCajaPesosSucursal){
        return  $MovimientosCajaPesosSucursal ;
   });   

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