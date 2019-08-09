<?php  
namespace App\Managers\Proyecto;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Managers\ManagerBase;

/**
* 
*/
class crear_proyecto_admin_manager extends ManagerBase 
{


  public function getRules()
  {
    $rules = [
      'img'         => 'required',
      'name'        => 'required',
      'description' => 'required',
      'fecha'       => 'required',
      'ubicacion'   => 'required'
             ];

    return $rules;
  }
 
  
  
  
}