<?php

Route::post('get_avisos_de_esta_empresa',
    [
        'uses' => 'Admin_Empresa\AvisosController@get_avisos_de_esta_empresa',
        'as'   => 'get_avisos_de_esta_empresa',
    ]);

Route::post('crear_aviso_empresa',
    [
        'uses' => 'Admin_Empresa\AvisosController@crear_aviso_empresa',
        'as'   => 'crear_aviso_empresa',
    ]);
