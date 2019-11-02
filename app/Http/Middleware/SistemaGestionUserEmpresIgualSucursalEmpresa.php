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


        $Session_nombre = 'sucursal' . $request->get('empresa_id');
        //verifico si la sesion tiene sucursal
        if($Session_nombre)
        {            
           
            $Validacion      = true;
            
            if($request->has('sucursal_id'))
            {
                if(($UserEmpresa->sucursal_id == $request->get('sucursal_id')) || ($User->role >= 3) )
                { 

                  $Validacion = true;          
                  $Mensaje    = 'El usuario puede entrar';

                  $SucursalRepo = new SucursalEmpresaRepo();

                  Session::put($Session_nombre, $SucursalRepo->find($request->get('sucursal_id')) );
                }  
                else
                {
                  $Validacion = false; 
                  $Mensaje    = 'No puede operar está sucursal';
                }
            }   

            $request->attributes->add(['sucursal_desde_middleware' => Session::get($Session_nombre)]); 

        }
        else
        {
            //si tiene sucursal id la request
            if($request->has('sucursal_id'))
            {

                if(($UserEmpresa->sucursal_id == $request->get('sucursal_id')) || ($User->role >= 3) )
                { 

                  $Validacion = true;          
                  $Mensaje    = 'El usuario puede entrar';

                  $SucursalRepo = new SucursalEmpresaRepo();

                  Session::put($Session_nombre, $SucursalRepo->find($request->get('sucursal_id')) );
                }  
                else
                {
                  $Validacion = false; 
                  $Mensaje    = 'No puede operar está sucursal';
                }


                
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
    



        if(!$Validacion)
        {
                if($request->isJson())
                {
                     return ['Validacion'          => $Validacion,
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