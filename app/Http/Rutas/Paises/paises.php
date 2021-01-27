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
