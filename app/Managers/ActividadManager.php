<?php
namespace App\Managers\EmpresaGestion;

use App\Managers\ManagerBase;

class ActividadManager extends ManagerBase
{
    public function getRules()
    {
        $rules = [
            'name'        => 'required',
            'empresa_id'  => 'required',
            'sucursal_id' => 'required',
        ];

        return $rules;
    }
}
