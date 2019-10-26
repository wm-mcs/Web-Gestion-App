<?php  
namespace App\Managers\EmpresaGestion;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Managers\ManagerBase;

/**
* 
*/
class IngresarMovimientoCajaManager extends ManagerBase 
{


  public function getRules()
  {
    $rules = [
      'moneda'             => 'required',
      'valor'              => 'numeric|required',
      'tipo_saldo'         => 'required',
      'nombre'             => 'required'
          
             ];

    return $rules;
  }
 
  
  
  
}