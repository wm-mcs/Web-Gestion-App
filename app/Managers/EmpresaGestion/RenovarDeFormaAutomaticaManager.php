<?php  
namespace App\Managers\EmpresaGestion;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Managers\ManagerBase;

/**
* 
*/
class RenovarDeFormaAutomaticaManager extends ManagerBase 
{


  public function getRules()
  {
    $rules = [
      'empresa_id'  => 'required',
      'socio_id'    => 'required'
             ];

    return $rules;
  }
 
  
  
  
}