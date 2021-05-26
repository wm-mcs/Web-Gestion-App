<?php
Route::get('/panel-de-reservas',
    [
        'uses' => 'Admin_Empresa\ReservaController@get_panel_de_reservas',
        'as'   => 'get_panel_de_reservas']);

Route::post('/get_sucursales_public',
    [
        'uses' => 'Admin_Empresa\ReservaController@get_sucursales_public',
        'as'   => 'get_sucursales_public']);

Route::post('/get_clases_para_reservar_public',
    [
        'uses' => 'Admin_Empresa\ReservaController@get_clases_para_reservar_public',
        'as'   => 'get_clases_para_reservar_public']);
