<?php

namespace App\Http\Middleware;

use App\Helpers\HelpersGenerales;
use App\Repositorios\EmpresaConSociosoRepo;
use Closure;
use Crypt;
use Illuminate\Support\Facades\Cache;

class SocioPublicoMiddleware
{
    public function handle($request, Closure $next)
    {

        $ip      = strval($_SERVER['REMOTE_ADDR']);
        $mensaje = 'Esperá unos segundo y volvé a intentar. Hay muchas solicitudes en este momento.';

        if ($ip === null) {
            if ($request->isJson()) {
                HelpersGenerales::formateResponseToVue(false, $mensaje);
            } else {
                return $mensaje;
            }
        }

        if (Cache::has($ip)) {
            Cache::increment($ip);
        } else {
            Cache::put($ip, 1, 5);
        }

        if (Cache::get($ip) > 30) {
            if ($request->isJson()) {
                HelpersGenerales::formateResponseToVue(false, $mensaje);
            } else {
                return $mensaje;
            }
        }

        $Repo = new EmpresaConSociosoRepo();

        $empresa_id = $request->get('id') != null ? Crypt::decrypt($request->get('id')) : $request->get('empresa_id');

        $request->attributes->add(['empresa_desde_middleware' => $Repo->find($empresa_id)]);

        return $next($request);
    }
}
