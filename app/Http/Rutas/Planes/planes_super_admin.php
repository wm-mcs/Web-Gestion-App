<?php
Route::post('crear_plan',
    [
        'uses' => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Admin_Vendedores_Controllers@crear_plan',
        'as' => 'crear_plan',
    ]);

Route::post('editar_plan_empresa',
    [
        'uses' => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Admin_Vendedores_Controllers@editar_plan_empresa',
        'as' => 'editar_plan_empresa',
    ]);
