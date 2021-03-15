<?php

Route::get('getIndex',
    [
        'uses' => 'Admin_Empresa\AgendaController@getIndex',
        'as'   => 'getIndex']);
