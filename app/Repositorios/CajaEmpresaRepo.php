<?php 

namespace App\Repositorios;

use App\Entidades\CajaEmpresa;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;



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
    $Entidad->tipo_movimiento  = $tipo_movimeinto;
    $Entidad->fecha_ingreso    = $fecha_ingreso;

    if($servicio != null)
    {
      $Entidad->servicio_id = $servicio->id;
    }
    $Entidad->save();

    

  }


  public function getMovimeintosDeEstaSecursalYServicio($servicio_id,$sucursal_id)
  {
    return $this->getEntidad()
                ->where('servicio_id',$servicio_id)  
                ->where('sucursal_id',$sucursal_id )
                ->get();
  }


 


  
}