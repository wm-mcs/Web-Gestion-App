<?php  
namespace App\Managers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Managers\ManagerBase;

/**
* 
*/
class envio_solicitud_trabajo_manager extends ManagerBase 
{


  public function getRules()
  {
    $rules = [
      'name'      => 'required',
      'email'     => 'required|email',
      'mensaje'   => 'required',
      'file'      => 'required'
             ];

    return $rules;
  }
 
  
  
  
}