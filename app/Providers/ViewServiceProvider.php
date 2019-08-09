<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\ViewComposers\EmpresaViewComposer;


class ViewServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->make('view')->composer(['layouts.admin_layout.header.global',
                                            'layouts.user_layout.navbar.navbar',
                                            'layouts.user_layout.footer.footer-general',
                                            'emails.layouts.layout_principal',
                                            'layouts.admin_layout.columna_derecha.columna',
                                            'layouts.gestion_socios_layout.columna_derecha.columna',
                                            'layouts.user_layout.user_layout'
                                            ]
            , EmpresaViewComposer::class);

       
    }


    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
