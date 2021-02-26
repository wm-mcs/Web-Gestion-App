<?php

namespace App\Entidades\Traits;

trait empresaFuncionalidadesVerificar
{

    public function verificarSiPuedeUsarEstaFuncionalidad($keyFuncionalidad, $empresa)
    {
        $ServiciosDisponibles = $empresa->servicios_contratados_a_empresas_activos;

        if ($ServiciosDisponibles->count() > 0) {
            $Plan = $ServiciosDisponibles->first()->tipo_de_servicio;

        } else {
            return false;
        }

        return (isset($Plan) && $empresa->$keyFuncionalidad == 'si' || $Plan->$keyFuncionalidad == 'si') ? true : false;
    }

}
