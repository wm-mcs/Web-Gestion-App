<?php

Route::get('get_paises',
    [
        'uses' => 'Admin_Empresa\PaisesController@get_paises',
        'as' => 'get_paises',
    ]);
