<?php  
namespace App\Managers\EmpresaGestion;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Managers\ManagerBase;

/**
* 

*/
class PaisManager extends ManagerBase 
{


['name','code','currencyCode','estado'];

  public function getRules()
  {
    $rules = [
      'name'                => 'required',
      'code'                => 'required',
      'currencyCode'        => 'required',
      'estado'              => 'required'

             ];

    return $rules;
  }
 
   
  
  
}