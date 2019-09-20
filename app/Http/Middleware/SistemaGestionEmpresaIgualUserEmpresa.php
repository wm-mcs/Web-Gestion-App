<?php

namespace App\Http\Middleware;
use App\Repositorios\UserEmpresaRepo;
use Illuminate\Support\Facades\Cache;

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
    public function handle($request, Closure $next)
    {
        $UserEmpresa  = new UserEmpresaRepo();
        $User         = auth()->user();
        $Validacion   = false;

        $Validacion_de_usuario_vinculado_empresa = 
        Cache::remember('UserIgualEmpresa'.$User->id, 10, function() use($UserEmpresa,$User,$request)
                         {
                              return $UserEmpresa->verificarSiUserYEmpresaEstanVicnulados($User->id,$request->get('empresa_id'));
                         }
                        ); 



        if($Validacion_de_usuario_vinculado_empresa['Validacion'] == true  || $User->role > 6)
        {
              //el usuario que vicnula
              $UserEmpresa = $Validacion_de_usuario_vinculado_empresa['UserEmpresa'];            
              $Validacion = true;

              //agrego al user desde aqui para no pedirlo en el controller
              $request->attributes->add(['user_desde_middleware' => $User ]);
              $request->attributes->add(['user_empresa_desde_middleware' => $UserEmpresa ]);
              
        }

        if(!$Validacion)
        {
            return ['Validacion'          => $Validacion,
                    'Validacion_mensaje'  => 'No tienes permiso para hacer eso:  no controlas a está empresa'];
        }

        

        return $next($request);
    }
}


