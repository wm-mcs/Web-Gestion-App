<?php

namespace App\Repositorios;

use App\Entidades\Agenda;

class PaisRepo extends BaseRepo
{

    public function getEntidad()
    {
        return new Agenda();
    }

}
