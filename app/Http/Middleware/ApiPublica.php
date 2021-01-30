<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Cache;

class ApiPublica
{

    public function handle($request, Closure $next)
    {
        $ip = strval($request->header('Ip'));
        $nombre = 'ip_del_consultante_' . $ip;

        if ($ip != null) {
            $nombre = 'ip_del_consultante_' . $ip;
            if (Cache::has($nombre)) {

                Cache::increment($nombre);

            } else {
                Cache::put($nombre, 1, Carbon::now('America/Montevideo')->addMinutes(5));
            }

            if (Cache::get($nombre) > 6) {
                return ['Validacion' => false,
                    'Validacion_mensaje' => 'Muchas solicitudes.'];
            }

            // No tengo claro porque hice esto. Seguramente sea para probar
            $request->attributes->add(['ip' => $ip, 'cache' => Cache::get($nombre)]);
        }

        return $next($request);
    }
}
