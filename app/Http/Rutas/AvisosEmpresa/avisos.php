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

Route::post('borrar_aviso',
    [
        'uses' => 'Admin_Empresa\AvisosController@borrar_aviso',
        'as'   => 'borrar_aviso',
    ]);

Route::post('crear_aviso_empresa_masivo',
    [
        'uses' => 'Admin_Empresa\AvisosController@crear_aviso_empresa_masivo',
        'as'   => 'crear_aviso_empresa_masivo',
    ]);
