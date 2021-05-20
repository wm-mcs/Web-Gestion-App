<?php
namespace App\Managers\EmpresaGestion;

use App\Managers\ManagerBase;

class VincularGrupoASocio extends ManagerBase
{
    public function getRules()
    {
        $rules = [
            'grupo_id'    => 'required',
            'empresa_id'  => 'required',
            'socio_id'    => 'required',
            'sucursal_id' => 'required',
        ];

        return $rules;
    }
}
