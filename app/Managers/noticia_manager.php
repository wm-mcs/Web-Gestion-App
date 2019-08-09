<?php  
namespace App\Managers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Managers\ManagerBase;

/**
* 
*/
class noticia_manager extends ManagerBase 
{


  public function getRules()
  {
    $rules = [
      'name'            => 'required',
      'sub_name'        => 'required',
      'description'     => 'required',
      'img'             => 'required'
             ];

    return $rules;
  }
 
  
  
  
}