<?php 

Route::get('get_admin_categorias',
[
  'uses'  => 'Admin_Empresa\Admin_Categoria_Controllers@get_admin_categorias',
  'as'    => 'get_admin_categorias'
]);

Route::get('get_admin_categorias_crear',
[
  'uses'  => 'Admin_Empresa\Admin_Categoria_Controllers@get_admin_categorias_crear',
  'as'    => 'get_admin_categorias_crear'
]);

Route::post('set_admin_categorias_crear',
[
  'uses'  => 'Admin_Empresa\Admin_Categoria_Controllers@set_admin_categorias_crear',
  'as'    => 'set_admin_categorias_crear'
]);

Route::get('get_admin_categorias_editar{id}',
[
  'uses'  => 'Admin_Empresa\Admin_Categoria_Controllers@get_admin_categorias_editar',
  'as'    => 'get_admin_categorias_editar'
]);

Route::patch('set_admin_categorias_editar{id}',
[
  'uses'  => 'Admin_Empresa\Admin_Categoria_Controllers@set_admin_categorias_editar',
  'as'    => 'set_admin_categorias_editar'
]);