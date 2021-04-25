<?php

namespace App\Http\Middleware;

use App\Helpers\HelpersGenerales;
use Closure;
use Illuminate\Support\Facades\Session;

class SocioLogInPublic
{
    public function handle($request, Closure $next)
    {

        $Empresa = $request->get('empresa_desde_middleware');

        if (!Session::has('socio-auth')) {
            if ($request->isJson()) {
                HelpersGenerales::formateResponseToVue(false, 'Hay un error de conexión. Actualizá la página para solucionar.');
            } else {
                return redirect()->$Empresa->route_reservas->with('alert-rojo', 'La sesión expiró. Ingresá los datos de nuevo.');
            }
        }

        return $next($request);
    }
}
