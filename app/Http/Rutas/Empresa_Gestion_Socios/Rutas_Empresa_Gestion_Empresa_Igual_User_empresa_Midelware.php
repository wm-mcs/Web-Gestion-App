<?php
require __DIR__ . '/../Analiticas/analiticas.php';
require __DIR__ . '/../Agenda/agenda.php';
require __DIR__ . '/../Actividades/actividades.php';
require __DIR__ . '/../Servicios/servicios.php';
require __DIR__ . '/../Grupo/grupos.php';

Route::post('confirmar_lectura_de_aviso',
    [
        'uses' => 'Admin_Empresa\AvisosController@confirmar_lectura_de_aviso',
        'as'   => 'confirmar_lectura_de_aviso',
    ]);

Route::post('/get_reservas_del_dia',
    [
        'uses' => 'Admin_Empresa\ReservaController@get_reservas_del_dia',
        'as'   => 'get_reservas_del_dia']);

Route::post('/eliminar_reserva_desde_panel_admin',
    [
        'uses' => 'Admin_Empresa\ReservaController@eliminar_reserva_desde_panel_admin',
        'as'   => 'eliminar_reserva_desde_panel_admin']);

Route::post('/marcar_que_realizo_reserva_desde_panel_admin',
    [
        'uses' => 'Admin_Empresa\ReservaController@marcar_que_realizo_reserva_desde_panel_admin',
        'as'   => 'marcar_que_realizo_reserva_desde_panel_admin']);

Route::post('get_control_access_view',
    [
        'uses' => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@get_control_access_view',
        'as'   => 'get_control_access_view']);

Route::get('get_pagina_de_configuracion',
    [
        'uses' => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@get_pagina_de_configuracion',
        'as'   => 'get_pagina_de_configuracion']);

Route::post('control_acceso_socio',
    [
        'uses' => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@control_acceso_socio',
        'as'   => 'control_acceso_socio']);

Route::post('get_control_acceso_movimientos',
    [
        'uses' => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@get_control_acceso_movimientos',
        'as'   => 'get_control_acceso_movimientos']);

Route::post('movimientos_de_accesos_view', [
    'uses' => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@movimientos_de_accesos_view',
    'as'   => 'movimientos_de_accesos_view']);

Route::post('getMovimientosParaPanelDeIngresoDeMovimeintoDeCaja',
    [
        'uses' => 'Admin_Empresa\TipoDeMovimientoController@getMovimientosParaPanelDeIngresoDeMovimeintoDeCaja',
        'as'   => 'getMovimientosParaPanelDeIngresoDeMovimeintoDeCaja',
    ]);

Route::post('getMovimientosParaPanelDeIngresoDeMovimeintoAlSocio',
    [
        'uses' => 'Admin_Empresa\TipoDeMovimientoController@getMovimientosParaPanelDeIngresoDeMovimeintoAlSocio',
        'as'   => 'getMovimientosParaPanelDeIngresoDeMovimeintoAlSocio',
    ]);

//Desde Panel creo socio
Route::post('post_crear_socio_desde_modal',
    [
        'uses' => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@post_crear_socio_desde_modal',
        'as'   => 'post_crear_socio_desde_modal']);

//editar al socio
Route::post('post_editar_socio_desde_modal',
    [
        'uses' => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@post_editar_socio_desde_modal',
        'as'   => 'post_editar_socio_desde_modal']);

//Para ir al panel de la empresa vista del cliente
Route::post('get_socios_activos',
    [
        'uses' => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@get_socios_activos',
        'as'   => 'get_socios_activos']);

Route::post('get_socios_inactivos',
    [
        'uses' => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@get_socios_inactivos',
        'as'   => 'get_socios_inactivos']);

//Para buscar los socios
Route::post('buscar_socios_activos',
    [
        'uses' => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@buscar_socios_activos',
        'as'   => 'buscar_socios_activos']);

//editar la empresa la parte de actualziacion automatica
Route::post('editar_empresa_renovacion_automatica',
    [
        'uses'       => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@editar_empresa_renovacion_automatica',
        'as'         => 'editar_empresa_renovacion_automatica',
        'middleware' => 'SistemaGestionUserGerarquia:3']);
