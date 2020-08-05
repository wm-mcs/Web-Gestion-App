<?php

namespace App\Http\Controllers\Traits;



trait validatorMesaagesTrait{

    
    /**
     * Me da devuelve el array con el formato para vue.
     *
     * @return array
     */
    public function getErroresCuandoNoPasaValidator($manager)
    {
      return ['Validacion'          => false,
              'Validacion_mensaje'  => 'Algo anda mal: ' . $manager->getErrors()];
    }

}  