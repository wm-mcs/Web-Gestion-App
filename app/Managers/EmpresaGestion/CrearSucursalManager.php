<?php  
namespace App\Managers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Managers\ManagerBase;

/**
* 
*/
class CrearSucursalManager extends ManagerBase 
{


  public function getRules()
  {
    $rules = [
      'name'      => 'required',
             ];

    return $rules;
  }
 
  
  
  
}