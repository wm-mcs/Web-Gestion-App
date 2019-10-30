<?php  
namespace App\Managers\EmpresaGestion;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Managers\ManagerBase;

/**
* 
*/
class AnularCajaManager extends ManagerBase 
{


  public function getRules()
  {
    $rules = [
      'empresa_id'    => 'required',
      'caja_id'       => 'required'
             ];

    return $rules;
  }
 
   
  
  
}