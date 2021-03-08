<?php
Route::post('get_analiticas',
    [
        'uses' => 'Admin_Empresa\AnaliticasController@get_analiticas',
        'as' => 'get_analiticas',
    ]);

Route::post('get_movimientos_de_caja_para_analiticas',
    [
        'uses' => 'Admin_Empresa\AnaliticasController@get_movimientos_de_caja_para_analiticas',
        'as' => 'get_movimientos_de_caja_para_analiticas',
    ]);

Route::post('get_servicios_vendidos',
    [
        'uses' => 'Admin_Empresa\AnaliticasController@get_servicios_vendidos',
        'as' => 'get_servicios_vendidos',
    ]);
