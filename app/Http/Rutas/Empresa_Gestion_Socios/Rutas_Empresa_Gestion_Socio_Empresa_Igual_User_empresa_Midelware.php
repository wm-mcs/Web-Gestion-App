<?php



Route::post('get_servicios_de_socio',
[
  'uses'       => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@get_servicios_de_socio',
  'as'         => 'get_servicios_de_socio']);  






Route::post('agregar_servicio_a_socio',
[
  'uses'       => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@agregar_servicio_a_socio',
  'as'         => 'agregar_servicio_a_socio']);  











Route::group(['middleware' => 'SistemaGestionServicioSocioIdIgualSocioId'],function()
{
   require __DIR__ .'Rutas_Empresa_Gestion_Empresa_Servicio_Socio_Id_Igual_Socio_Id_Midelware.php';
});