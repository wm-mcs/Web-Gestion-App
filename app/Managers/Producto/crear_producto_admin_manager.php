<?php  
namespace App\Managers\Producto;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Managers\ManagerBase;

/**
* 
*/
class crear_producto_admin_manager extends ManagerBase 
{


  public function getRules()
  {
    $rules = [
      'img'               => 'required',
      'name'              => 'required',
      'description'       => 'required'
          
             ];

    return $rules;
  }
 
  
  
  
}