<?php

Route::get('get_paises_index',
    [
        'uses' => 'Admin_Empresa\PaisesController@getIndex',
        'as' => 'get_paises_index',
    ]);

Route::get('get_paises_todos',
    [
        'uses' => 'Admin_Empresa\PaisesController@get_paises_todos',
        'as' => 'get_paises_todos',
    ]);

Route::post('crear_pais',
    [
        'uses' => 'Admin_Empresa\PaisesController@crear_pais',
        'as' => 'crear_pais',
    ]);

Route::post('editar_pais',
    [
        'uses' => 'Admin_Empresa\PaisesController@editar_pais',
        'as' => 'editar_pais',
    ]);
