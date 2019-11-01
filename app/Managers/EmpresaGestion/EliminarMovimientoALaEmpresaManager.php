<?php  
namespace App\Managers\EmpresaGestion;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Managers\ManagerBase;

/**
* 
*/
class EliminarMovimientoALaEmpresaManager extends ManagerBase 
{


  public function getRules()
  {
    $rules = [ 
      'empresa_id'         => 'required',
      'name'               => 'required',
      'moneda'             => 'required',
      'valor'              => 'required',
      'fecha_vencimiento'  => 'required'
             ];

    return $rules;
  }
   
  
  
  
}