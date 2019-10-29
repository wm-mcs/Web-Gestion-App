<?php  
namespace App\Managers\EmpresaGestion;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Managers\ManagerBase;

/**
* 
*/
class AnularCajaManager extends ManagerBase 
{


  public function getRules()
  {
    $rules = [
      'empresa_id'    => 'required',
      'moneda'        => 'required',
      'valor'         => 'required',
      'tipo_saldo'    => 'required',
      'nombre'        => 'required',
      'socio_id'      => 'required',
      'paga'          => 'required'
             ];

    return $rules;
  }
 
  
  
  
}