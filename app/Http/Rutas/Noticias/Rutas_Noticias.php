<?php 

Route::get('get_admin_noticias',
[
  'uses'  => 'Admin_Empresa\Admin_Noticias_Controllers@get_admin_noticias',
  'as'    => 'get_admin_noticias'
]);

Route::get('get_admin_noticias_crear',
[
  'uses'  => 'Admin_Empresa\Admin_Noticias_Controllers@get_admin_noticias_crear',
  'as'    => 'get_admin_noticias_crear'
]);

Route::post('set_admin_noticias_crear',
[
  'uses'  => 'Admin_Empresa\Admin_Noticias_Controllers@set_admin_noticias_crear',
  'as'    => 'set_admin_noticias_crear'
]);

Route::get('get_admin_noticias_editar{id}',
[
  'uses'  => 'Admin_Empresa\Admin_Noticias_Controllers@get_admin_noticias_editar',
  'as'    => 'get_admin_noticias_editar'
]);

Route::patch('set_admin_noticias_editar{id}',
[
  'uses'  => 'Admin_Empresa\Admin_Noticias_Controllers@set_admin_noticias_editar',
  'as'    => 'set_admin_noticias_editar'
]);
