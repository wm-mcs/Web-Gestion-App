<?php
Route::get('get-planes-public',
    [
        'uses' => 'Admin_Empresa\PlanesController@get_planes_publica',
        'as' => 'get_planes_publica',
    ]);
