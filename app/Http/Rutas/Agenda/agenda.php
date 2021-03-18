<?php

Route::get('get_index_agenda',
    [
        'uses' => 'Admin_Empresa\AgendaController@getIndex',
        'as'   => 'get_index_agenda']);
