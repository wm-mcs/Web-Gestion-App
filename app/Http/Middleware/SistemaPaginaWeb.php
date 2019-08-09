<?php

namespace App\Http\Middleware;

use Closure;

class SistemaPaginaWeb
{







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
        /**
         * obtengo el usuario conectado con el helper auth();
         */
        $user = auth()->user();

        if($user->role == 'adminMcos522')
        {
            return $next($request);
        }

        if($user->contrato_pagina_web != 'si' )
        {
            return redirect()->route('get_home')
                             ->with('alert-rojo' , 'Sin permisos para ingresar a esa pagina ') ; 
        }

        return $next($request);
    }
}