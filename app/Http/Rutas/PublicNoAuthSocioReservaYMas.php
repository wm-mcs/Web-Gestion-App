<?php
Route::get('{name}/{hash}}',
    [
        'uses' => 'Admin_Empresa\ActividadController@get_panel_de_empresa_publico',
        'as'   => 'get_panel_de_empresa_publico']);
