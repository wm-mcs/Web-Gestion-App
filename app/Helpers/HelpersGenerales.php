<?php

namespace App\Helpers;

class HelpersGenerales
{

    /**
     * Es la función que utilozo para formatear todas las respuestas para Vue.
     *
     * @return array
     */
    public static function formateResponseToVue($Validacion, $Validacion_mensaje, $Data = null)
    {
        return [
            'Validacion' => $Validacion,
            'Validacion_mensaje' => $Validacion_mensaje,
            'Data' => $Data,
        ];

    }

}
