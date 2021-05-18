<?php
namespace App\Managers\EmpresaGestion;

use App\Managers\ManagerBase;

class GrupoManager extends ManagerBase
{
    public function getRules()
    {
        $rules = [
            'name'       => 'required',
            'empresa_id' => 'required',

            'estado'     => 'required',
        ];

        return $rules;
    }
}
