<?php

namespace App\Http\Middleware;
use App\Repositorios\VendedorEmpresaRepo;
use Illuminate\Support\Facades\Cache;

use Closure;

class SistemaGestionEmpresaIgualVendedorEmpresa
{
                         
    public function handle($request, Closure $next)
    {
        $UserEmpresa  = new VendedorEmpresaRepo();
        $User         = auth()->user();
        $Validacion   = false;
        $request->attributes->add(['user_desde_middleware' => $User ]);

        if($User->role > 6){
            return $next($request);
        }

        $Validacion_de_usuario_vinculado_empresa = 
        Cache::remember('UserIgualEmpresa'.$User->id, 10, function() use($UserEmpresa,$User,$request)
                         {
                              return $UserEmpresa->verificarSiUserYEmpresaEstanVicnulados($User->id,$request->get('empresa_id'));
                         }
                        ); 

        if($Validacion_de_usuario_vinculado_empresa['Validacion'] == true  || $User->role > 6)
        {
            // E l   u s u a r i o   q u e   v i n c u l a 
            $UserEmpresa = $Validacion_de_usuario_vinculado_empresa['UserEmpresa'];            
            $Validacion  = true;

            // A g r e g o   a l   r e q u e s t              
            $request->attributes->add(['user_empresa_desde_middleware' => $UserEmpresa ]);              
        }
        else
        {               
            $Mensaje    = 'No tienes permiso para hacer éso:  no controlas a ésta empresa';
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