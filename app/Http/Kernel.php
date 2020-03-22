<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \App\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\VerifyCsrfToken::class,
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth'                                        => \App\Http\Middleware\Authenticate::class,
        'auth.basic'                                  => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'guest'                                       => \App\Http\Middleware\RedirectIfAuthenticated::class,        
        'verificad'                                   => \App\Http\Middleware\RestriccionUsuarioNoVerificado::class,
        'role'                                        => \App\Http\Middleware\ControlAcceso::class,
        'SistemaGestionSocios'                        => \App\Http\Middleware\SistemaGestionSocios::class,
        'SistemaPaginaWeb'                            => \App\Http\Middleware\SistemaPaginaWeb::class,
        'SistemaGestionUserGerarquia'                 => \App\Http\Middleware\SistemaGestionUserGerarquia::class,
        'SistemaGestionEmpresaIgualUserEmpresa'       => \App\Http\Middleware\SistemaGestionEmpresaIgualUserEmpresa::class,
        'SistemaGestionUserEmpresIgualSociaEmpresa'   => \App\Http\Middleware\SistemaGestionUserEmpresIgualSociaEmpresa::class,
        'SistemaGestionServicioSocioIdIgualSocioId'   => \App\Http\Middleware\SistemaGestionServicioSocioIdIgualSocioId::class,
        'SistemaGestionUserEmpresIgualSucursalEmpresa'=> \App\Http\Middleware\SistemaGestionUserEmpresIgualSucursalEmpresa::class,
        'SistemaGestionEmpresaIgualVendedorEmpresa'   => \App\Http\Middleware\SistemaGestionEmpresaIgualVendedorEmpresa::class,
        'ApiPublica'                                  => \App\Http\Middleware\ApiPublica::class
    ];
}
