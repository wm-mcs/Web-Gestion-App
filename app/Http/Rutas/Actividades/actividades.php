<?php
Route::get('get_actividades_index',
    [
        'uses' => 'Admin_Empresa\ActividadController@getIndex',
        'as'   => 'get_actividades_index']);

Route::post('get_actividad',
    [
        'uses' => 'Admin_Empresa\ActividadController@getEntidades',
        'as'   => 'get_actividad']);

Route::post('crear_actividad',
    [
        'uses' => 'Admin_Empresa\ActividadController@crearEntidad',
        'as'   => 'crear_actividad']);

Route::post('editar_actividad',
    [
        'uses' => 'Admin_Empresa\ActividadController@editarEntidad',
        'as'   => 'editar_actividad']);
