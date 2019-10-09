<?php

namespace App\Http\Middleware;
use App\Repositorios\SocioRepo;
use App\Repositorios\UserEmpresaRepo;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

use Closure;

class SistemaGestionUserEmpresIgualSucursalEmpresa
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
        $UserEmpresaRepo = new UserEmpresaRepo();
        $User            = $request->get('user_desde_middleware');        
        $UserEmpresa     = $request->get('user_empresa_desde_middleware');
        
        $Validacion      = false;


        //verifico si la sesion tiene sucursal
        if(Session::has('sucursal'))
        {

        }
        else
        {
            //si tiene sucursal id la request
            if($request->has('sucursal_id'))
            {

            }
            else
            {   $Mensaje    = 'Debes elegír una sucursal.';

                if($request->ajax())
                {
                     return ['Validacion'          => false,
                             'Validacion_mensaje'  => $Mensaje];
                }
                
                return redirect()->route('get_home')->with('alert-danger',$Mensaje);
            }
        }    
    


        if(($UserEmpresa->empresa_id == $Socio->empresa_id) || ($User->role > 6) )
        { 

          $Validacion = true;          
          $request->attributes->add(['socio_desde_middleware' => $Socio]);
        }
        else
        {
          $Validacion = false;
          $Mensaje    = 'No tienes permiso para hacer eso:  el socio no es de está empresa';
        }  

        if(!$Validacion)
        {
            return ['Validacion'          => $Validacion,
                    'Validacion_mensaje'  => $Mensaje];
        }

        

        return $next($request);
    }
}