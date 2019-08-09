<?php 

//Get Listado
Route::get('get_admin_empresas_gestion_socios',
[
  'uses'       => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@get_admin_empresas_gestion_socios',
  'as'         => 'get_admin_empresas_gestion_socios',

  'middleware' => 'role:adminMcos522'     
]);



//GET Crear
Route::get('get_admin_empresas_gestion_socios_crear',
[
  'uses'       => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@get_admin_empresas_gestion_socios_crear',
  'as'         => 'get_admin_empresas_gestion_socios_crear',

  'middleware' => 'role:adminMcos522'
]);

Route::post('set_admin_empresas_gestion_socios_crear',
[
  'uses'            => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@set_admin_empresas_gestion_socios_crear',
  'as'              => 'set_admin_empresas_gestion_socios_crear',

  'middleware' => 'role:adminMcos522'
]);


//GET Editar
Route::get('get_admin_empresas_gestion_socios_editar_{id}',
[
  'uses'       => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@get_admin_empresas_gestion_socios_editar',
  'as'         => 'get_admin_empresas_gestion_socios_editar',

  'middleware' => 'role:adminMcos522'
]); 


//Patch Editar
Route::patch('set_admin_empresas_gestion_socios_editar_{id}',
[
  'uses'       => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@set_admin_empresas_gestion_socios_editar',
  'as'         => 'set_admin_empresas_gestion_socios_editar',
  'middleware' => 'role:adminMcos522'
]); 




//Para ir al panel de la empresa vista del cliente
Route::get('get_empresa_panel_de_gestion{id}',
[
  'uses'       => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@get_empresa_panel_de_gestion',
  'as'         => 'get_empresa_panel_de_gestion']);  


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
Route::get('get_socios_activos{empresa_id}',
[
  'uses'       => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@get_socios_activos',
  'as'         => 'get_socios_activos']);  



//Para ir al panel del socio
Route::get('get_socio_panel{id}',
[
  'uses'       => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@get_socio_panel',
  'as'         => 'get_socio_panel']);  



//Para ir al panel del socio
Route::get('get_socio{id}',
[
  'uses'       => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@get_socio',
  'as'         => 'get_socio']);  



Route::get('get_tipo_servicios{empresa_id}',
[
  'uses'       => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@get_tipo_servicios',
  'as'         => 'get_tipo_servicios']);  




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

Route::post('agregar_servicio_a_socio',
[
  'uses'       => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@agregar_servicio_a_socio',
  'as'         => 'agregar_servicio_a_socio']);  

Route::post('get_servicios_de_socio',
[
  'uses'       => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@get_servicios_de_socio',
  'as'         => 'get_servicios_de_socio']);  



Route::get('borrar_servicio_de_socio{id}',
[
  'uses'       => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@borrar_servicio_de_socio',
  'as'         => 'borrar_servicio_de_socio']);  



Route::post('editar_servicio_a_socio',
[
  'uses'       => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@editar_servicio_a_socio',
  'as'         => 'editar_servicio_a_socio']);  


Route::post('indicar_que_se_uso_el_servicio_hoy',
[
  'uses'       => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@indicar_que_se_uso_el_servicio_hoy',
  'as'         => 'indicar_que_se_uso_el_servicio_hoy']);  





Route::post('eliminar_estado_de_cuenta',
[
  'uses'       => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@eliminar_estado_de_cuenta',
  'as'         => 'eliminar_estado_de_cuenta']);  


























