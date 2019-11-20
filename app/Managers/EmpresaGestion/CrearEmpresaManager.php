<?php  
namespace App\Managers\EmpresaGestion;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Managers\ManagerBase;


class CrearEmpresaManager extends ManagerBase 
{


  public function getRules()
  {
    $rules = [
      'empresa_name'     => 'required',
      'empresa_celular'  => 'required',
      'empresa_email'    => 'required',
      'user_name'        => 'required',
      'user_email'       => 'required',
      'user_celular'     => 'required',
      'plan_id'          => 'required',
      'factura_con_iva'  => 'required'
             ];

    return $rules;
  }
 
  
  
  
}