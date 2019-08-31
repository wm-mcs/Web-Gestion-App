<?php

namespace App\Http\Middleware;
use App\Repositorios\SocioRepo;

use Closure;

class SistemaGestionUserEmpresIgualSociaEmpresa
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
        /**
         * obtengo el usuario conectado con el helper auth();
         */
        $User       = auth()->user();
        $ReposSocio = new SocioRepo();
        $Socio      = $ReposSocio->find($request->get('socio_id'));
        
        $Validacion = false;


        if(($User->empresa_gestion_id == $Socio->empresa_id) || ($User->role > 6) )
        { 


          //agrego al user desde aqui para no pedirlo en el controller
          $request->attributes->add(['user_desde_middleware'  => $User ]);
          $request->attributes->add(['socio_desde_middleware' => $Socio]);
        }  

        if(!$Validacion)
        {
            return ['Validacion'          => $Validacion,
                    'Validacion_mensaje'  => 'No tienes permiso para hacer eso:  el socio no es de está empresa'];
        }

        

        return $next($request);
    }
}