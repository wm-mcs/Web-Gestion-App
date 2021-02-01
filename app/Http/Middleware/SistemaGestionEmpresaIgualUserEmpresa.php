<?php

namespace App\Http\Middleware;

use App\Repositorios\UserEmpresaRepo;
use Closure;
use Illuminate\Support\Facades\Cache;

class SistemaGestionEmpresaIgualUserEmpresa
{

    /**
     * 1 = Usuario operador
     * 2 = Usuario moderador de la empresa
     * 3 = Usuario vendeor
     * 4 = Usuario Administrador principal
     */

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    //le paso como 3º parametre
    //lo que viene de la Ruta
    public function handle($request, Closure $next)
    {
        $UserEmpresa = new UserEmpresaRepo();
        $User = auth()->user();
        $Validacion = false;
        $request->attributes->add(['user_desde_middleware' => $User]);

        /* if($User->role > 6){
        return $next($request);
        }*/

        $Validacion_de_usuario_vinculado_empresa =
        Cache::remember('UserIgualEmpresa' . $User->id . 'empresa' . $request->get('empresa_id'), 10, function () use ($UserEmpresa, $User, $request) {
            return $UserEmpresa->verificarSiUserYEmpresaEstanVicnulados($User->id, $request->get('empresa_id'));
        }
        );

        if ($Validacion_de_usuario_vinculado_empresa['Validacion'] == true) {
            //el usuario que vicnula
            $UserEmpresa = $Validacion_de_usuario_vinculado_empresa['UserEmpresa'];
            $Validacion = true;

            //agrego al user desde aqui para no pedirlo en el controller

            $request->attributes->add(['user_empresa_desde_middleware' => $UserEmpresa]);

        } else {

            $Mensaje = 'No tienes permiso para hacer éso:  no controlas a ésta empresa';
            if ($request->isJson()) {
                return ['Validacion' => false,
                    'Validacion_mensaje' => $Mensaje];
            } else {
                return redirect()->route('get_home')->with('alert-danger', $Mensaje);
            }
        }

        return $next($request);
    }
}
