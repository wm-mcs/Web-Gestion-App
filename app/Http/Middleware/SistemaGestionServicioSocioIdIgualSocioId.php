<?php

namespace App\Http\Middleware;
use App\Repositorios\SocioRepo;
use App\Repositorios\ServicioContratadoSocioRepo;

use Closure;

class SistemaGestionServicioSocioIdIgualSocioId
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
        $User          = auth()->user();
        $RepoServicio  = new ServicioContratadoSocioRepo();
        $Servicio      = $RepoServicio->find($request->get('servicio_id'));
        $Socio         = $request->get('socio_desde_middleware'); 
        
        $Validacion = false;


        if(($Socio->id == $Servicio->socio_id) || ($User->role > 6) )
        { 

            $Validacion = true;
          //agrego al user desde aqui para no pedirlo en el controller
          $request->attributes->add(['servicio_desde_middleware'  => $Servicio ]);
          
        }  

        if(!$Validacion)
        {
            return ['Validacion'          => $Validacion,
                    'Validacion_mensaje'  => 'No tienes permiso para hacer eso:  el servicio no es de ese socio'];
        }

        

        return $next($request);
    }
}