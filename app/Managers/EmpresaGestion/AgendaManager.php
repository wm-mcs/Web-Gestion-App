<?php
namespace App\Managers\EmpresaGestion;

use App\Managers\ManagerBase;

class AgendaManager extends ManagerBase
{
    public function getRules()
    {
        $rules = [

            'empresa_id'            => 'required',
            'hora_inicio'           => 'required',
            'hora_fin'              => 'required',
            'actividad_id'          => 'required',
            'tiene_limite_de_cupos' => 'required',

        ];

        return $rules;
    }
}
