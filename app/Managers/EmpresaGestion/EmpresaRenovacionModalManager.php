<?php  
namespace App\Managers\EmpresaGestion;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Managers\ManagerBase;

/**
* 
*/
class EmpresaRenovacionModalManager extends ManagerBase 
{


  public function getRules()
  {
    $rules = [
      'empresa_id'                                   => 'required',
      'actualizar_servicios_socios_automaticamente'  => 'required',
             ];

    return $rules;
  }
 
  
  
  
}