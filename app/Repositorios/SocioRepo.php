<?php 

namespace App\Repositorios;

use App\Entidades\Socio;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

/**
* Repositorio de consultas a la base de datos User
*/
class SocioRepo extends BaseRepo
{
  
  public function getEntidad()
  {
    return new Socio();
  }



  public function getSociosBusqueda($empresa_id, $palabra_de_busqueda,$cantidad_de_resultados = null)
  {
       $socios_base  = $this->getEntidad()->active()->where('empresa_id',$empresa_id);

       if($palabra_de_busqueda != null)
       {        
       

       $array_de_ids = [];

       $colecciones_separado  = $socios_base->where('name',$palabra_de_busqueda)->get();  
       $array_de_ids          = $this->traer_poner_ids($colecciones_separado,$array_de_ids);

       $colecciones_separado2 = $socios_base->where('rut',$palabra_de_busqueda)->get();  
       $array_de_ids          = $this->traer_poner_ids($colecciones_separado2,$array_de_ids);

       $colecciones_separado3 = $socios_base->where('razon_social',$palabra_de_busqueda)->get();  
       $array_de_ids          = $this->traer_poner_ids($colecciones_separado3,$array_de_ids);

       $colecciones_separado4 = $socios_base->where('email',$palabra_de_busqueda)->get();  
       $array_de_ids          = $this->traer_poner_ids($colecciones_separado3,$array_de_ids);

       $colecciones_separado5 = $socios_base->where('celular',$palabra_de_busqueda)->get();  
       $array_de_ids          = $this->traer_poner_ids($colecciones_separado3,$array_de_ids);

       $array_de_ids          = array_unique($array_de_ids); 

       $Socios                = $this->getEntidad()->whereIn('id',$array_de_ids)->orderBy('updated_at','desc')->get();

      }
      else
      {
        $Socios               = $socios_base->orderBy('updated_at','desc')->get();
      }


      if($cantidad_de_resultados != null)
      {
        if($Socios->count() >  $cantidad_de_resultados)
        {
          $Socios = $Socios->take($cantidad_de_resultados);
        }
        else
        {
          $Socios = $Socios;
        }
      }
      
      return $Socios;





     
  }


  //para la busqueda
  public function traer_poner_ids($coleccion,$array)
  {
    if($coleccion->count() > 0)
    {
      foreach($coleccion as $producto)  
       {
        array_push($array,$producto->id);
       } 
       
    }

    return $array;
  } 


  
}