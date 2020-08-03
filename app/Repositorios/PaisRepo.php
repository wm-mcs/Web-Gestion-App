<?php 

namespace App\Repositorios;

use App\Entidades\Pais;
use Illuminate\Support\Facades\Cache;
use App\Repositorios\Traits\imagenesTrait;


class PaisRepo extends BaseRepo
{

  use imagenesTrait;
  
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