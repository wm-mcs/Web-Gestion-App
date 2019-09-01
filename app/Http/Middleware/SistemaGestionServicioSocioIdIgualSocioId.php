<?php

namespace App\Http\Middleware;
use App\Repositorios\ServicioContratadoSocioRepo;

use Closure;

class SistemaGestionServicioSocioIdIgualSocioId
{

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