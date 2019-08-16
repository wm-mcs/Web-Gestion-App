<?php

namespace App\Http\Middleware;

use Closure;

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
    public function handle($Request, Closure $next)
    {
        /**
         * obtengo el usuario conectado con el helper auth();
         */
        $User       = auth()->user();
        $Validacion = false;


        if($User->empresa_gestion_id == $Request->get('empresa_id') )
        { 
          //agrego al user desde aqui para no pedirlo en el controller
          $Request->attributes->add(['user_desde_middleware' => $User ]);
        }  

        if(!$Validacion)
        {
            return ['Validacion'          => $Validacion,
                    'Validacion_mensaje'  => 'No tienes permiso para hacer eso :('];
        }

        

        return $next($Request);
    }
}


