<?php

namespace App\Http\Controllers\Admin_Empresa;

use App\Http\Controllers\Controller;
use App\Repositorios\EmpresaConSociosoRepo;

class ReservaController extends Controller
{
    protected $EmpresaConSociosoRepo;

    public function __construct(EmpresaConSociosoRepo $EmpresaConSociosoRep
    ) {
        $this->EmpresaConSociosoRepo = $EmpresaConSociosoRep;

    }
}
