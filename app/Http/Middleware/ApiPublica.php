<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

use Closure;

class ApiPublica
{
                         
    public function handle($request, Closure $next)
    {
        $ip = strval($request->header('Ip'));
        $nombre = 'ip_del_consultante_'.$ip;

        if($ip != null)
        {
          $nombre = 'ip_del_consultante_'.$ip;
          if(Cache::has($nombre))
          {
            
            Cache::increment($nombre);

          }
          else
          {
            Cache::put($nombre,1,Carbon::now('America/Montevideo')->addMinutes(5));
          }

          if(Cache::get($nombre) > 2)
          {
             return ['Validacion'          => false,
                     'Validacion_mensaje'  => 'Muchas solicitudes.'];
          }

           $request->attributes->add(['ip'  => $ip,'cache' => Cache::get($nombre) ]);
        }

      

       

        return $next($request);
    }
}