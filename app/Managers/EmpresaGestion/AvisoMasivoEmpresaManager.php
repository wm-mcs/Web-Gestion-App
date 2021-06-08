<?php
namespace App\Managers\EmpresaGestion;

use App\Managers\ManagerBase;

class AvisoMasivoEmpresaManager extends ManagerBase
{

    public function getRules()
    {
        $rules = [

            'title' => 'required',
            'text'  => 'required',
            'type'  => 'required',

        ];

        return $rules;
    }

}
