<?php  
namespace App\Managers\EmpresaGestion;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Managers\ManagerBase;

/**
* 
*/
class CrearPlanManager extends ManagerBase 
{


  public function getRules()
  {
    $rules = [
      'name'                => 'required',
      'tipo'                => 'required',
      'moneda'              => 'required',
      'valor'               => 'required',
      'cantidad_socios'     => 'required',
      'cantidad_sucursales' => 'required'
    ];

    return $rules;
  }
 
   
  
  
}