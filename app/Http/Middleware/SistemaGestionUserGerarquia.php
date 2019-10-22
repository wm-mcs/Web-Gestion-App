<?php

namespace App\Http\Middleware;

use Closure;

class SistemaGestionUserGerarquia
{



    /**
     * 1  = Usuario simple 
     * 2  = Usuario operador
     * 3  = Usuario moderador de la empresa
     * 4  = Usuario vendeor
     * 
     *
     *
     *
     *
     *
     * 10 = Usuario Administrador principal
     */




 
    public function handle($request, Closure $next, $gerarquia)
    {
        /**
         * obtengo el usuario conectado con el helper auth();
         */
        $user = auth()->user();

       

        if($user->role < $gerarquia )
        {

            
                $Mensaje =    'No tienes permiso para hacer eso :(';  
                if($request->isJson())
                {
                     return ['Validacion'          => false,
                             'Validacion_mensaje'  => $Mensaje];
                }
                else
                {
                   return redirect()->route('get_home')->with('alert-danger',$Mensaje); 
                }
        }


        return $next($request);
    }
}