<?php  
namespace App\Managers\Users;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Managers\ManagerBase;

/**
* 
*/
class user_registro extends ManagerBase 
{


  public function getRules()
  {
    $rules = [
      'name'      => 'required',
      'email'     => 'required|unique:users'
             ];

    return $rules;
  }
 
  
  
  
}