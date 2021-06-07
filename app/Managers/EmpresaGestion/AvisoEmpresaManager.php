<?php
namespace App\Managers\EmpresaGestion;

use App\Managers\ManagerBase;

class AvisoEmpresaManager extends ManagerBase
{

    public function getRules()
    {
        $rules = [
            'empresa_id' => 'required',
            'title'      => 'required',
            'text'       => 'required',
            'type'       => 'required',

        ];

        return $rules;
    }

}
