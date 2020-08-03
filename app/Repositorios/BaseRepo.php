<?php 
namespace App\Repositorios;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Repositorios\Emails\EmailsRepo;
use Input;
use Intervention\Image\ImageManagerStatic as Image;

/**
* Contiene metodos comunes para todo los repositorios
*/
abstract class BaseRepo 
{
    
  protected $entidad;    

  public function __construct()
  {      
    $this->entidad      = $this->getEntidad();
  }

  /**
   * funcion que va a hacer creada el los repo que extiendan.
   */
  abstract public function getEntidad();

  public function getEmailsRepo()
  {
   return new EmailsRepo();
  }

  public function find($id)
  {
    return $this->entidad->find($id);
  }

  public function destroy_entidad($id)
  {
    $entidad_a_borrar = $this->find($id);
    $entidad_a_borrar->delete();
  }

  //elimina esta entidad
  public function destruir_esta_entidad($Entidad)
  {
    $Entidad->delete();
  }

  //se cambia la propiedad borrado a si
  public function destruir_esta_entidad_de_manera_logica($Entidad)
  {
    $Entidad->borrado = 'si';
    $Entidad->save();
  }

  /**
   * Entidades Activas 
   */
  public function getEntidadActivas()
  {
    return $this->entidad                  
                ->where('estado','si')              
                ->orderBy('id','desc')
                ->get();
  }

  /**
   * Entidades Activas 
   */
  public function getEntidadActivasOrdenadasSegun($Order_by,$Asc_desc)
  {
    return $this->entidad                  
                ->where('estado','si')  
                ->where('borrado','no')            
                ->orderBy($Order_by,$Asc_desc)
                ->get();
  }

  /**
   * Entidades Activas Paginadas
   */
  public function getEntidadActivasPaginadas($request,$paginacion)
  {
    return $this->entidad
                ->name($request->get('name')) 
                ->where('estado','si')               
                ->orderBy('id','desc')
                ->paginate($paginacion);
  }


  public function getEntidadesConEstosId($ids)
  {
     $array = array_unique($ids);

     return  $this->entidad
                  ->where('estado','si') 
                  ->whereIn('id',$array)
                  ->get();
  }


  //setters
  public function setEntidadDato($Entidad,$request,$Propiedades)
  {
      foreach ($Propiedades as $Propiedad) 
      {
        if($request->input($Propiedad) != null)
        {            
         $Entidad->$Propiedad = $request->input($Propiedad);
        }
        elseif($request->input($Propiedad) == '')
        {
          $Entidad->$Propiedad = trim($request->input($Propiedad));
        }         
      } 

      $Entidad->save();     

      return $Entidad;
  }

  //setters recibe un objeto en lugar del reques
  public function setEntidadDatoObjeto($Entidad,$objeto,$Propiedades)
  {
      foreach ($Propiedades as $Propiedad) 
      {         
         $Entidad->$Propiedad = $objeto->$Propiedad; 
      } 

      $Entidad->save();     

      return $Entidad;
  }

  /**
  * grabar entidad atributo especifico
  */
  public function setAtributoEspecifico($Entidad,$atributo,$valor)
  {
    if($valor != '')
    {
      $Entidad->$atributo = trim($valor);
      $Entidad->save();

      return $Entidad;
    }      
  }
    

  /**
   * Válido para movimiento de caja o estado de cuenta
   */
  public function getDetalleAlAnular($EntidadAAnular)
  {
    return 'Anulación del movimiento ' . $EntidadAAnular->id . ' : ' . $EntidadAAnular->detalle;
  }
    

}   
