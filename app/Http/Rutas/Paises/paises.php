<?php

Route::get('get_paises_index',
    [
        'uses' => 'Admin_Empresa\PaisesController@getIndex',
        'as' => 'get_paises_index',
    ]);
