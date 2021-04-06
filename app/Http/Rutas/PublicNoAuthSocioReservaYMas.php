<?php
Route::get('/{name}/panel/',
    [
        'uses' => 'Admin_Empresa\ReservaController@get_panel_de_empresa_publico',
        'as'   => 'get_panel_de_empresa_publico']);
