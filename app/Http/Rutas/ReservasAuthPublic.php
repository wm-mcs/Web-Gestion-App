<?php
Route::get('/panel-de-reservas',
    [
        'uses' => 'Admin_Empresa\ReservaController@get_panel_de_reservas',
        'as'   => 'get_panel_de_reservas']);
