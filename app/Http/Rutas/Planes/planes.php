<?php
Route::get('get_planes_empresa',
    [
        'uses' => 'Admin_Empresa\PlanesController@get_planes_empresa',
        'as' => 'get_planes_empresa',
    ]);
Route::get('get_planes_index',
    [
        'uses' => 'Admin_Empresa\PlanesController@get_planes_empresa',
        'as' => 'get_planes_index',
    ]);
