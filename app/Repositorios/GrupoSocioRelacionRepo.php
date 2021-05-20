<?php

namespace App\Repositorios;

use App\Entidades\GrupoSocioRelacion;

class GrupoSocioRelacionRepo extends BaseRepo
{
    public function getEntidad()
    {
        return new GrupoSocioRelacion();
    }

    public function socioEstaVinculadoConEsteGrupo($Empresa_id, $Sucursal_id, $Socio_id, $Grupo_id)
    {
        $Entidades = $this->getEntidad()
            ->where('empresa_id', $Empresa_id)
            ->where('sucursal_id', $Sucursal_id)
            ->where('socio_id', $Socio_id)
            ->where('grupo_id', $Grupo_id)
            ->get();

        if ($Entidades->count() > 0) {
            return true;
        }

        return false;
    }

    public function vincularSocioAGrupo($Empresa_id, $Sucursal_id, $Socio_id, $Grupo_id)
    {

        if ($this->socioEstaVinculadoConEsteGrupo($Empresa_id, $Sucursal_id, $Socio_id, $Grupo_id)) {

        } else {
            $Entidad              = $this->getEntidad();
            $Entidad->empresa_id  = $Empresa_id;
            $Entidad->sucursal_id = $Sucursal_id;
            $Entidad->socio_id    = $Socio_id;
            $Entidad->grupo_id    = $Grupo_id;
            $Entidad->save();
        }

    }

    public function desVincularSocioAGrupo($Empresa_id, $Sucursal_id, $Socio_id, $Grupo_id)
    {
        $Entidades =
        $this->getEntidad()
            ->where('empresa_id', $Empresa_id)
            ->where('sucursal_id', $Sucursal_id)
            ->where('grupo_id', $Grupo_id)
            ->where('socio_id', $Socio_id)
            ->get();

        if ($Entidades->count() > 0) {
            foreach ($Entidades as $Entidad) {
                $this->destruir_esta_entidad($Entidad);
            }

        }

    }

    public function getRelacionesDeEsteGrupo($Empresa_id, $Sucursal_id, $Grupo_id)
    {
        return $this->getEntidad()
            ->where('empresa_id', $Empresa_id)
            ->where('sucursal_id', $Sucursal_id)
            ->where('grupo_id', $Grupo_id)
            ->get();
    }

    public function getRelacionesDeGruposDeEstSocio($Empresa_id, $Socio_id)
    {
        return $this->getEntidad()
            ->where('empresa_id', $Empresa_id)
            ->where('socio_id', $Socio_id)
            ->get();
    }
}
