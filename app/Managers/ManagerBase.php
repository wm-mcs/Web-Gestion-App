<?php  
namespace App\Managers;

/**
* 
*/
abstract class ManagerBase 
{
  /**
   * Manager de la entidad correspondiente
   */
  protected $entidad;

  /**
   * Datos de los Request para validar
   */
  protected $data;

  protected $errors;

  public function __construct($entidad = Null, $data)
  {
    $this->entidad  = $entidad;

                      /**
                       * usamos Array_only ( Helper de Laravel)
                       * para verificar solo data valida que pertenece a nuestras 
                       * reglas
                       */
    $this->data     = array_only($data, array_keys($this->getRules()));
  }

  /**
   * exigo que las clases que extiendan implemente la funcion
   */
  abstract public function getRules();

  
 /**
  * Aqui es donde llamo al Fasat Validator ya con los parametros
  */
  public function isValid()
  {
    $rules = $this->getRules();

    $validation = \Illuminate\Support\Facades\Validator::
                 make($this->data, $rules);

    /**
     * Guardo en esta variable si la validacion paso o no
     * me devulve true o false.
     */
    $isValid = $validation->passes();

    /**
     * los errores de la validacion
     */
    $this->errors = $validation->messages();

    return $isValid;


  }

  /**
   * Funsion que devuelve los errores
   */
  public function getErrors()
  {
    return $this->errors;
  }


  public function getData()
  {
    return $this->data;
  }

  
  



}