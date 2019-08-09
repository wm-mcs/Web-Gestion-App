<?php  
namespace App\Managers\Users;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Managers\ManagerBase;

/**
* 
*/
class user_admin_crear extends ManagerBase 
{


  public function getRules()
  {
    $rules = [
      'name'      => 'required',
      'email'     => 'required|email|unique:users',
      'telefono'  => 'required',
      'estado'    => 'required',
      'role'      => 'required'
             ];

    return $rules;
  }
 
  
  
  
}