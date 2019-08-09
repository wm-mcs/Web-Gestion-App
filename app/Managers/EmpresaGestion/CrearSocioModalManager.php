<?php  
namespace App\Managers\EmpresaGestion;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Managers\ManagerBase;

/**
* 
*/
class CrearSocioModalManager extends ManagerBase 
{


  public function getRules()
  {
    $rules = [
      'name'               => 'required',
      'email'              => 'required|email',
      'celular'            => 'required',
      'cedula'             => 'required|numeric'
          
             ];

    return $rules;
  }
 
  
  
  
}