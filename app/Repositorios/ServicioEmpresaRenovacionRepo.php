<?php 

namespace App\Repositorios;

use App\Entidades\ServicioEmpresaRenovacion;


/**
* Repositorio de consultas a la base de datos User
*/
class ServicioEmpresaRenovacionRepo extends BaseRepo
{
  
  public function getEntidad()
  {
    return new ServicioEmpresaRenovacion();
  }



  public function getServiciosDeRenovacionDeLaEmpresaActivos($empresa_id)
  {
    return $this->getEntidad()
                ->where('borrado','no')
                ->where('empresa_id',$empresa_id)
                ->where('se_renueva_automaticamente','si')
                ->get();
  }



  public function setServicioRenovacion($empresa_id,$tipo_servicio,$fecha)
  {

    


        //busco si existe algun servicio con ese id
        $Servicio_buscado = $this->getEntidad()
                                 ->where('empresa_id',$empresa_id)
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
          $Servicio->empresa_id                 = $empresa_id;
          $Servicio->tipo_servicio_id           = $tipo_servicio->id;
          $Servicio->se_renueva_automaticamente = 'si';
          $Servicio->fecha_ultima_renovacion    = $fecha;


          $Servicio->save();
        }

        $this->ActualizarCache($empresa_id);

    
  }


  public function ActualizarCache($empresa_id)
{
 
   $Array_cache = [
                      'ServiciosDerenovacionEmpresa'.$empresa_id, 
                    ];

    foreach ($Array_cache as $cache )
    {
      if (Cache::has($cache))
      {
       Cache::forget($cache);
      }
    } 


   $Servicios =  $this->getServiciosDeRenovacionDeLaEmpresaActivos($empresa_id);
   Cache::remember('ServiciosDerenovacionEmpresa'.$empresa_id, 8000, function() use ($Servicios){
        return  $Servicios ;
   }); 

 


 


  
}