<?php
Route::get('get_actividades_index',
    [
        'uses' => 'Admin_Empresa\ActividadController@getIndex',
        'as'   => 'get_actividades_index']);
