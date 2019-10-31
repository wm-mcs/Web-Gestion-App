<?php  
namespace App\Managers\EmpresaGestion;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Managers\ManagerBase;

/**
* 
*/
class AgregarMovimientoALaEmpresaManager extends ManagerBase 
{


  public function getRules()
  {
    $rules = [
      'empresa_id'   => 'required',
      'moneda'       => 'required',
      'valor'        => 'required',
      'tipo_saldo'   => 'required',
      'nombre'       => 'required',      
      'paga'         => 'required'
             ];

    return $rules;
  }
 
  
  
  
}