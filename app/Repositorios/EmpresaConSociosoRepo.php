<?php

namespace App\Repositorios;

use App\Entidades\EmpresaConSocios;
use App\Repositorios\Traits\imagenesTrait;

class EmpresaConSociosoRepo extends BaseRepo
{
    use imagenesTrait;

    public function getEntidad()
    {
        return new EmpresaConSocios();
    }

    public function CrearEmpresaComoVendedor($nombre, $email, $celular, $factura_con_iva, $rut, $razon_social, $pais = 'UY')
    {
        $Entidad = $this->getEntidad();

        $Entidad->name = $nombre;
        $Entidad->estado = 'si';
        $Entidad->codigo_pais_whatsapp = '598';
        $Entidad->email = $email;
        $Entidad->celular = $celular;
        $Entidad->factura_con_iva = $factura_con_iva;
        $Entidad->rut = $rut;
        $Entidad->razon_social = $razon_social;
        $Entidad->save();
        return $Entidad;
    }

}
