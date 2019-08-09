<?php

namespace App\Http\Middleware;

use Closure;

class ControlAcceso
{
/**
 * Nivel de Gerarquia de los usuarios.
 */
protected $Gerarquia = [

    'adminMcos522'         => 5 ,
    'admin_empresa'        => 4 ,
    'user_grado_2'         => 3 ,
    'user_grado_1'         => 2 ,
    'user'                 => 1 
    ];







    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

                           //le paso como 3º parametre
                           //lo que viene de la Ruta 
    public function handle($request, Closure $next, $role)
    {
        /**
         * obtengo el usuario conectado con el helper auth();
         */
        $user = auth()->user();

        if($this->Gerarquia[$user->role] < $this->Gerarquia[$role] )
        {
            return redirect()->route('get_home')
                             ->with('alert-rojo' , 'Sin permisos para ingresar a esa pagina ') ; 
        }

        return $next($request);
    }
}
