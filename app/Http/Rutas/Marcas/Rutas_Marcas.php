<?php 

Route::get('get_admin_marcas',
[
  'uses'  => 'Admin_Empresa\Admin_Marcas_Controllers@get_admin_marcas',
  'as'    => 'get_admin_marcas'
]);

Route::get('get_admin_marcas_crear',
[
  'uses'  => 'Admin_Empresa\Admin_Marcas_Controllers@get_admin_marcas_crear',
  'as'    => 'get_admin_marcas_crear'
]);

Route::post('set_admin_marcas_crear',
[
  'uses'  => 'Admin_Empresa\Admin_Marcas_Controllers@set_admin_marcas_crear',
  'as'    => 'set_admin_marcas_crear'
]);

Route::get('get_admin_marcas_editar{id}',
[
  'uses'  => 'Admin_Empresa\Admin_Marcas_Controllers@get_admin_marcas_editar',
  'as'    => 'get_admin_marcas_editar'
]);

Route::patch('set_admin_marcas_editar{id}',
[
  'uses'  => 'Admin_Empresa\Admin_Marcas_Controllers@set_admin_marcas_editar',
  'as'    => 'set_admin_marcas_editar'
]);