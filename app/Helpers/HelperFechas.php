<?php

namespace App\Helpers;

class HelperFechas
{
    /**
     * Envio un día en formato internacional. Y me devuelve el día en texto en español
     *
     * @return array
     */
    public static function getNombreDeDia($Dia_numero)
    {
        $Dias = [

            1 => 'lunes',
            2 => 'martes',
            3 => 'miércoles',
            4 => 'jueves',
            5 => 'viernes',
            6 => 'sábado',
            7 => 'domingo',

        ];

        return $Dias[$Dia_numero];

    }
}
