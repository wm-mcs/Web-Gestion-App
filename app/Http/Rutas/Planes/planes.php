<?php
Route::get('get_planes_empresa',
    [
        'uses' => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Admin_Vendedores_Controllers@get_planes_empresa',
        'as' => 'get_planes_empresa',
    ]);
