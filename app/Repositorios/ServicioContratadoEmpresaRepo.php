<?php 

namespace App\Repositorios;

use App\Entidades\ServicioContratadoEmpresa;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

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
    $Entidad->estado            = 'si';
    $Entidad->empresa_id        = $Empresa->id;
    $Entidad->name              = $Servicio->name;
    $Entidad->moneda            = $Servicio->moneda;
    $Entidad->valor             = $this->getValorSiEsConIVAONO($Empresa->factura_con_iva, $Servicio->valor);
    $Entidad->tipo_servicio_id  = $Servicio->id;
    $Entidad->fecha_vencimiento = $Fecha_vencimiento;
    $Entidad->save();

    $this->ActualizarCache($Empresa->id);

    return $Entidad;
  }


  public function getServiciosActivosDeEstaEmpresa($empresa_id)
  {
    $Hoy = Carbon::now('America/Montevideo');  
    return $this->getEntidad()
                ->where('empresa_id',$empresa_id)
                ->where('borrado','no')
                ->where('fecha_vencimiento','>', $Hoy )
                ->orderBy('created_at', 'DESC')
                ->get();
  }






  public function ActualizarCache($empresa_id)
  {
     $Array_cache = [
                      'ServiciosActivosEmpresa'.$empresa_id,
                    ];

    foreach ($Array_cache as $cache )
    {
      if (Cache::has($cache))
      {
       Cache::forget($cache);
      }
    } 


   $Servicos_activos =  $this->getServiciosActivosDeEstaEmpresa($empresa_id);
   Cache::remember('ServiciosActivosEmpresa'.$empresa_id, 8000, function() use ($Servicos_activos){
        return  $Servicos_activos ;
   }); 

   
  }



 


  
}