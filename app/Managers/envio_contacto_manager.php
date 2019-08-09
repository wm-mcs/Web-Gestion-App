<?php  
namespace App\Managers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Managers\ManagerBase;

/**
* 
*/
class envio_contacto_manager extends ManagerBase 
{


  public function getRules()
  {
    $rules = [
      'name'      => 'required',
      'email'     => 'required|email',
      'mensaje'   => 'required'
             ];

    return $rules;
  }
 
  
  
  
}