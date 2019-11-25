<?php  
namespace App\Managers\EmpresaGestion;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Managers\ManagerBase;

/**
* 
*/
class CrearTipoServicioManager extends ManagerBase 
{


  public function getRules()
  {
    $rules = [
      'empresa_id'      => 'required',
      'name'            => 'required',
      'tipo'            => 'required',
      'moneda'          => 'required',
      'valor'           => 'required'
             ];

    return $rules;
  }
 
  
  
  
}