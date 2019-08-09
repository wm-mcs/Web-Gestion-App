<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RestriccionUsuarioNoVerificado
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /**
         * De esta maner obtengo el usuario conectado-
         * Otra forma de hacer lo mismo seria
         * usar el helper ... auth()->user() 
         */
        $user = Auth::user();

        if ( $user->registration_token != null )
        {
            return redirect()->route('get_home')
                             ->with('alert-rojo' , 'Por Favor debes verificar tu email');
        }  

        /**
         * Sino indicamos esto el middlewere no seguira a la siguiente
         * capa. 
         */
        return  $next($request) ; 
    }
}
