<?php
Route::post('get_analiticas',
    [
        'uses' => 'Admin_Empresa\AnaliticasController@get_analiticas',
        'as' => 'get_analiticas',
    ]);
