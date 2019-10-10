<?php

namespace App\Http\Middleware;
use App\Repositorios\SocioRepo;
use App\Repositorios\UserEmpresaRepo;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use App\Repositorios\SucursalEmpresaRepo;

use Closure;

class SistemaGestionUserEmpresIgualSucursalEmpresa
{

    public function handle($request, Closure $next)
    {
        $UserEmpresaRepo = new UserEmpresaRepo();
        $User            = $request->get('user_desde_middleware');        
        $UserEmpresa     = $request->get('user_empresa_desde_middleware');
        
        $Validacion      = false;


        //verifico si la sesion tiene sucursal
        if(Session::has('sucursal'))
        {            
            $request->attributes->add(['sucursal_desde_middleware' => Session::get('sucursal')]);
        }
        else
        {
            //si tiene sucursal id la request
            if($request->has('sucursal_id'))
            {
                $SucursalRepo = new SucursalEmpresaRepo();

                Session::put('sucursal', $SucursalRepo->find($request->get('sucursal_id')) );
            }
            else
            {   $Mensaje    = 'Debes elegír una sucursal.';

                

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