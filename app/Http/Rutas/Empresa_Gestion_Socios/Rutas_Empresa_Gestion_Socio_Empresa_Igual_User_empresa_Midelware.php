<?php


//Para ir al panel del socio
Route::post('get_socio',
[
  'uses'       => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@get_socio',
  'as'         => 'get_socio']);  


//Para ir al panel del socio
Route::post('get_socio_panel',
[
  'uses'       => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@get_socio_panel',
  'as'         => 'get_socio_panel']);  


Route::post('get_servicios_de_socio',
[
  'uses'       => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@get_servicios_de_socio',
  'as'         => 'get_servicios_de_socio']);  






Route::post('agregar_servicio_a_socio',
[
  'uses'       => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@agregar_servicio_a_socio',
  'as'         => 'agregar_servicio_a_socio']);  





Route::post('eliminar_estado_de_cuenta',
[
  'uses'       => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@eliminar_estado_de_cuenta',
  'as'         => 'eliminar_estado_de_cuenta']);  

Route::post('ingresar_movimiento_a_socio',
[
  'uses'       => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@ingresar_movimiento_a_socio',
  'as'         => 'ingresar_movimiento_a_socio']);  



Route::post('editar_servicio_renovacion',
[
  'uses'       => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@editar_servicio_renovacion',
  'as'         => 'editar_servicio_renovacion']);  


Route::group(['middleware' => 'SistemaGestionServicioSocioIdIgualSocioId'],function()
{
   require __DIR__ .'/Rutas_Empresa_Gestion_Empresa_Servicio_Socio_Id_Igual_Socio_Id_Midelware.php';
});