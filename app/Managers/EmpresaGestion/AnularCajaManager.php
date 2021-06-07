<?php
namespace App\Managers\EmpresaGestion;

use App\Managers\ManagerBase;

/**
 *
 */
class AnularCajaManager extends ManagerBase
{

    public function getRules()
    {
        $rules = [
            'empresa_id' => 'required',
            'caja_id'    => 'required',
        ];

        return $rules;
    }

}
