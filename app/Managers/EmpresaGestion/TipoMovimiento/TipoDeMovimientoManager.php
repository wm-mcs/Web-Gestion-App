<?php  
namespace App\Managers\EmpresaGestion\TipoMovimiento;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Managers\ManagerBase;


class TipoDeMovimientoManager extends ManagerBase 
{


  public function getRules()
  {
    $rules = [
      'name'                          => 'required',
      'tipo_saldo'                    => 'required',
      'movimiento_de_empresa_a_socio' => 'required',
      'movimiento_de_la_empresa'      => 'required'
    ];

    return $rules;
  }
 
   
  
  
}