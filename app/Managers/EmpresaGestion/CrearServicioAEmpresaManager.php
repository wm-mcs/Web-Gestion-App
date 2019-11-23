<?php  
namespace App\Managers\EmpresaGestion;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Managers\ManagerBase;

/**
* 
*/
class CrearServicioAEmpresaManager extends ManagerBase 
{


  public function getRules()
  {
    $rules = [
      'name'                => 'required',
      'tipo'                => 'required',
      'moneda'              => 'required',
      'valor'               => 'required',
      'tipo_servicio_id'     => 'required',
      'fecha_vencimiento'     => 'required',
      'paga' => 'required'
    ];

    return $rules;
  }
 
   
  
  
}