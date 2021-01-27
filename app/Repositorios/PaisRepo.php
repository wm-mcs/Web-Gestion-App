<?php

namespace App\Repositorios;

use App\Entidades\Pais;
use App\Repositorios\Traits\imagenesTrait;
use Illuminate\Support\Facades\Cache;

class PaisRepo extends BaseRepo
{

    use imagenesTrait;

    public function getEntidad()
    {
        return new Pais();
    }

    public function ActualizarCache()
    {
        Cache::forget('Paises');
    }

}
