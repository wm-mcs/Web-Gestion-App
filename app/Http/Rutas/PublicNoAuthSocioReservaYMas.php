<?php
Route::get('/{name}/panel/',
    [
        'uses' => 'Admin_Empresa\AuthPubliLoginController@get_auth_login_reserva_socio',
        'as'   => 'get_auth_login_reserva_socio']);

Route::post('post_auth_login_reserva_socio',
    [
        'uses' => 'Admin_Empresa\AuthPubliLoginController@post_auth_login_reserva_socio',
        'as'   => 'post_auth_login_reserva_socio']);
