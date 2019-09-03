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
      'email'              => 'required|email|unique',
      'celular'            => 'required|unique',
      'cedula'             => 'required|numeric|unique'
          
             ];

    return $rules;
  }
 
  
  
  
}