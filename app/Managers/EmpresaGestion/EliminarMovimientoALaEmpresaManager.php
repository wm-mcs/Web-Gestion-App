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
      'estado_de_cuenta'   => 'required'
             ];

    return $rules;
  }
   
  
  
  
}