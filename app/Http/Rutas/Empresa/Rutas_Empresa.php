<?php 

//Ruta de Home Panel Admin
Route::get('get_admin_home',
[
  'uses'  => 'Admin_Empresa\AdminController@get_admin_home',
  'as'    => 'get_admin_home'
]);



//Ruta de Admin Empresa Datos
Route::get('get_datos_corporativos',
[
  'uses'  => 'Admin_Empresa\Admin_Datos_Corporativos_Controller@get_datos_corporativos',
  'as'    => 'get_datos_corporativos'
]);

Route::patch('set_datos_corporativos',
[
  'uses'  => 'Admin_Empresa\Admin_Datos_Corporativos_Controller@set_datos_corporativos',
  'as'    => 'set_datos_corporativos'
]);