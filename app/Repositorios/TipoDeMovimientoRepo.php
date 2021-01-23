<?php

namespace App\Repositorios;

use App\Entidades\TipoDeMovimiento;

class TipoDeMovimientoRepo extends BaseRepo
{

    public function getEntidad()
    {
        return new TipoDeMovimiento();
    }

    /**
     * De manera manual traigo el tipo de movimiento que relaciona la venta de un producto.
     **/
    public function getMovimientoDeVentaDeServicio()
    {
        $id_de_movimiento_de_venta = 9;
        return $this->find($id_de_movimiento_de_venta);
    }
}
