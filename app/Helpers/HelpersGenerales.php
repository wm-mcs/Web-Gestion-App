<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;

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
            'Validacion'         => $Validacion,
            'Validacion_mensaje' => $Validacion_mensaje,
            'Data'               => $Data,
        ];
    }

    /**
     * Borra este cache
     *
     *  @return void
     */
    public static function forgetEsteCache($cache_name)
    {

        if (is_array($cache_name)) {
            foreach ($cache_name as $cache) {
                Cache::forget($cache);
            }
        } else {
            Cache::forget($cache_name);
        }
    }
}
