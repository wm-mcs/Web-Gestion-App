<?php

namespace App\Repositorios;

use App\Entidades\Agenda;

class AgendaRepo extends BaseRepo
{
    public function getEntidad()
    {
        return new Agenda();
    }
}
