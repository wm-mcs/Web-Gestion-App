<?php
Route::get('get_grupos_index',
    [
        'uses' => 'Admin_Empresa\GrupoController@getIndex',
        'as'   => 'get_grupos_index']);

Route::post('get_grupos',
    [
        'uses' => 'Admin_Empresa\GrupoController@getEntidades',
        'as'   => 'get_grupos']);

Route::post('crear_grupo',
    [
        'uses' => 'Admin_Empresa\GrupoController@crearEntidad',
        'as'   => 'crear_grupo']);

Route::post('editar_grupo',
    [
        'uses' => 'Admin_Empresa\GrupoController@editarEntidad',
        'as'   => 'editar_grupo']);
