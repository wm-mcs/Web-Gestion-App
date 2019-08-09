<?php 

namespace App\Repositorios;

use App\Entidades\Marca;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

/**
* Repositorio de consultas a la base de datos User
*/
class MarcaRepo extends BaseRepo
{
  
  public function getEntidad()
  {
    return new Marca();
  }

  //guetters/////////////////////////////////////////////////////////////////////

  /**
   * son las marcas para mostrar en la home
   */
  public function getMarcasHome()
  {
    return $this->getEntidad()
                ->where('rank', 3 )
                ->active()
                ->get()
                ->random(15);
  }


  /**
   * son las marcas para admin
   */
  public function getMarcasParaAdminOrdenadasAlfabeticamente($request,$paginacion)
  {
      return $this->getEntidad()
                  ->name($request->get('name'))                                 
                  ->orderBy('name','asc')
                  ->paginate($paginacion);
  }

  public function getMarcasParaWebOrdenadasAlfabeticamente($request,$paginacion)
  {
      return $this->getEntidad()
                  ->active()
                  ->name($request->get('name'))                                 
                  ->orderBy('name','asc')
                  ->paginate($paginacion);
  }

  public function getMarcasParaWebOrdenadasAlfabeticamenteSinPaginacion()
  {
    return $this->getEntidad()
                  ->active()                                               
                  ->orderBy('name','asc')
                  ->get();
  }
  //setters//////////////////////////////////////////////////////////////////////

 
  public function getMarcasDesordenadasRandomSegunRank($rank,$cantidad)
  {
    $marcas = $this->getEntidad()
                  ->active()
                  ->where('rank',$rank)
                  ->get()
                  ->shuffle();

    if($marcas->count( ) >= $cantidad) 
    {
      if($cantidad == null)
      {
        return $marcas;
      }
      return $marcas->take($cantidad)->get();
    } 
    else
    {
      return $marcas;
    }            

  }
 


  
}
