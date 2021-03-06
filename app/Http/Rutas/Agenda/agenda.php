<?php

Route::get('get_index_agenda',
    [
        'uses' => 'Admin_Empresa\AgendaController@getIndex',
        'as'   => 'get_index_agenda']);

Route::post('get_agendas',
    [
        'uses'       => 'Admin_Empresa\AgendaController@getEntidades',
        'as'         => 'get_agendas',
        'middleware' => 'SistemaGestionUserEmpresIgualSucursalEmpresa']);

Route::post('crear_agenda',
    [
        'uses' => 'Admin_Empresa\AgendaController@crearEntidad',
        'as'   => 'crear_agenda']);

Route::post('editar_agenda',
    [
        'uses' => 'Admin_Empresa\AgendaController@editarEntidad',
        'as'   => 'editar_agenda']);

Route::post('eleminar_agenda',
    [
        'uses' => 'Admin_Empresa\AgendaController@eliminarEntidad',
        'as'   => 'eleminar_agenda']);
