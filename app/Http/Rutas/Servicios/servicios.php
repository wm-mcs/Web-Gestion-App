<?php
Route::get('get_servicios_index',
    [
        'uses' => 'Admin_Empresa\ServiciosController@getIndex',
        'as'   => 'get_servicios_index']);

Route::get('get_tipo_servicios{empresa_id}',
    [
        'uses' => 'Admin_Empresa\ServiciosController@getEntidades',
        'as'   => 'get_tipo_servicios']);

Route::post('get_tipo_servicios',
    [
        'uses' => 'Admin_Empresa\ServiciosController@getEntidades',
        'as'   => 'get_tipo_servicios']);

Route::post('set_nuevo_servicio',
    [
        'uses' => 'Admin_Empresa\ServiciosController@crearEntidad',
        'as'   => 'set_nuevo_servicio']);

Route::post('delet_servicio',
    [
        'uses' => 'Admin_Empresa\ServiciosController@eleminarEntidad',
        'as'   => 'delet_servicio']);

Route::post('editar_servicio',
    [
        'uses' => 'Admin_Empresa\ServiciosController@editarEntidad',
        'as'   => 'editar_servicio']);
