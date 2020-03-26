<?php 

namespace App\Repositorios;

use App\Entidades\Pais;
use Illuminate\Support\Facades\Cache;

/**
* Repositorio de consultas a la base de datos User
*/
class PaisRepo extends BaseRepo
{
  
  public function getEntidad()
  {
    return new Pais();
  }

  public function ActualizarCache()
  {

    Cache::forget('Paises');
    Cache::remember('Paises', 10000, function() {
            return  $this->getEntidadActivasOrdenadasSegun('name','asc');
    });   
  }
    

   
  


 
}