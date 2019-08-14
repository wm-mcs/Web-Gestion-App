<?php

namespace App\Http\Middleware;

use Closure;

class SistemaGestionUserGerarquia
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
    public function handle($request, Closure $next, $gerarquia)
    {
        /**
         * obtengo el usuario conectado con el helper auth();
         */
        $user = auth()->user();

        if($user->role < $role )
        {
            return ['Validacion'          => false,
                    'Validacion_mensaje'  => 'No tienes permiso para hacer eso :('];
        }

        //agrego al user desde aqui para no pedirlo en el controller
        $request->attributes->add(['user_desde_middleware' => $user ]);

        return $next($request);
    }
}