<?php

Route::get('get_paises',
    [
        'uses' => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Admin_Vendedores_Controllers@get_paises',
        'as' => 'get_paises',
    ]);
