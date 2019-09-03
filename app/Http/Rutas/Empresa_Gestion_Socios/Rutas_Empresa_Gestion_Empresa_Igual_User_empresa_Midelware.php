<?php

//Desde Panel creo socio
Route::post('post_crear_socio_desde_modal',
[
  'uses'       => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@post_crear_socio_desde_modal',
  'as'         => 'post_crear_socio_desde_modal']);  

//editar al socio
Route::post('post_editar_socio_desde_modal',
[
  'uses'       => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@post_editar_socio_desde_modal',
  'as'         => 'post_editar_socio_desde_modal']);  

  



//Para ir al panel de la empresa vista del cliente
Route::post('get_socios_activos',
[
  'uses'       => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@get_socios_activos',
  'as'         => 'get_socios_activos']);  







Route::post('set_nuevo_servicio',
[
  'uses'       => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@set_nuevo_servicio',
  'as'         => 'set_nuevo_servicio']);    

Route::post('delet_servicio',
[
  'uses'       => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@delet_servicio',
  'as'         => 'delet_servicio']);  

Route::post('editar_servicio',
[
  'uses'       => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@editar_servicio',
  'as'         => 'editar_servicio']);  



















Route::post('indicar_que_se_uso_el_servicio_hoy',
[
  'uses'       => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@indicar_que_se_uso_el_servicio_hoy',
  'as'         => 'indicar_que_se_uso_el_servicio_hoy']);  





Route::post('eliminar_estado_de_cuenta',
[
  'uses'       => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@eliminar_estado_de_cuenta',
  'as'         => 'eliminar_estado_de_cuenta']);  


