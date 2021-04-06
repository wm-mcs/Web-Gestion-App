<?php

namespace App\Http\Middleware;

use App\Repositorios\SocioRepo;
use App\Repositorios\UserEmpresaRepo;
use Closure;

class SistemaGestionUserEmpresIgualSociaEmpresa
{

    /**
     * 1 = Usuario operador
     * 2 = Usuario moderador de la empresa
     * 3 = Usuario vendeor
     * 4 = Usuario Administrador principal
     */

    public function handle($request, Closure $next)
    {

        $UserEmpresaRepo = new UserEmpresaRepo();
        $User            = $request->get('user_desde_middleware');
        $ReposSocio      = new SocioRepo();
        $Socio           = $ReposSocio->find($request->get('socio_id'));
        $UserEmpresa     = $request->get('user_empresa_desde_middleware');

        $Validacion = false;

        if (($UserEmpresa->empresa_id == $Socio->empresa_id) || ($User->role > 6)) {

            $Validacion = true;
            $request->attributes->add(['socio_desde_middleware' => $Socio]);
        }

        if (!$Validacion) {
            return ['Validacion' => $Validacion,
                'Validacion_mensaje' => 'No tienes permiso para hacer eso:  el socio no es de está empresa'];
        }

        return $next($request);
    }
}
