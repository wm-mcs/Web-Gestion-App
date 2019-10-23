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
      'email'              => 'email|unique:socios',
      'celular'            => 'required|unique:socios',
      'cedula'             => 'numeric|unique:socios'
          
             ];

    return $rules;
  }
 
  
  
  
}