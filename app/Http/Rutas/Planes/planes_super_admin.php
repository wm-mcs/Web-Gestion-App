<?php
Route::post('crear_plan',
    [
        'uses' => 'Admin_Empresa\PlanesController@crear_plan',
        'as' => 'crear_plan',
    ]);

Route::post('editar_plan_empresa',
    [
        'uses' => 'Admin_Empresa\PlanesController@editar_plan_empresa',
        'as' => 'editar_plan_empresa',
    ]);
