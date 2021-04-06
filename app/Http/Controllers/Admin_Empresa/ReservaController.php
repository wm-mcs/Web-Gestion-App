<?php

namespace App\Http\Controllers\Admin_Empresa;

use App\Http\Controllers\Controller;
use App\Repositorios\EmpresaConSociosoRepo;
use Illuminate\Http\Request;

class ReservaController extends Controller
{
    protected $EmpresaConSociosoRepo;

    public function __construct(EmpresaConSociosoRepo $EmpresaConSociosoRep
    ) {
        $this->EmpresaConSociosoRepo = $EmpresaConSociosoRep;

    }

    public function get_panel_de_empresa_publico(Request $Request)
    {
        dd('panel');
    }

}
