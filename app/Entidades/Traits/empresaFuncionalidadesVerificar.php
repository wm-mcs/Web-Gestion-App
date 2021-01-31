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
            $ServiciosNoDisponibles = $empresa->servicios_contratados_a_empresas_desactivos;

            if ($ServiciosNoDisponibles->count() > 0) {
                $Plan = $ServiciosNoDisponibles->first()->tipo_de_servicio;

            }

        }

        dd($Plan);
    }

}
