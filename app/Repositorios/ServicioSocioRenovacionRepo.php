<?php 

namespace App\Repositorios;

use App\Entidades\ServicioSocioRenovacion;
use Illuminate\Support\Facades\Cache;


/**
* Repositorio de consultas a la base de datos User
*/
class ServicioSocioRenovacionRepo extends BaseRepo
{
  
  public function getEntidad()
  {
    return new ServicioSocioRenovacion();
  }



  public function getServiciosDeRenovacionDelSocioActivos($socio_id)
  {
    return $this->getEntidad()
                ->where('borrado','no')
                ->where('socio_id',$socio_id)
                ->where('se_renueva_automaticamente','si')
                ->get();
  }



  public function setServicioRenovacion($socio_id,$empresa_id,$tipo_servicio,$fecha)
  {

    if($tipo_servicio->tipo == 'mensual')
    {


        //busco si existe algun servicio con ese id
        $Servicio_buscado = $this->getEntidad()
                                 ->where('socio_id',$socio_id)
                                 ->where('tipo_servicio_id',$tipo_servicio->id)
                                 ->get();

        if($Servicio_buscado->count() > 0)
        {
          $Servicio = $Servicio_buscado->first();

          //me fijo que se pueda renovar automaticamente
          if($Servicio->se_renueva_automaticamente == 'si')
          {
            $Servicio->fecha_ultima_renovacion = $fecha ;
            $Servicio->save();
          }
        }  
        else
        {
          $Servicio                             = $this->getEntidad();
          $Servicio->socio_id                   = $socio_id;
          $Servicio->empresa_id                 = $empresa_id;
          $Servicio->tipo_servicio_id           = $tipo_servicio->id;
          $Servicio->se_renueva_automaticamente = 'si';
          $Servicio->fecha_ultima_renovacion    = $fecha;


          $Servicio->save();
        }

    }
  }


 


  
}