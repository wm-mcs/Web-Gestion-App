<?php 



//Ruta de Admin Empresa Datos
Route::get('get_datos_home_web',
[
  'uses'  => 'Admin_Empresa\Admin_HomeWeb_Controllers@get_datos_home_web',
  'as'    => 'get_datos_home_web'
]);

Route::patch('set_datos_home_web',
[
  'uses'  => 'Admin_Empresa\Admin_HomeWeb_Controllers@set_datos_home_web',
  'as'    => 'set_datos_home_web'
]);


Route::post('ssssasdasdasdset_img_home',
[
  'uses'  => 'Admin_Empresa\Admin_HomeWeb_Controllers@set_img_home',
  'as'    => 'set_img_home'
]);

Route::get('get_img_home{id}',
[
  'uses'  => 'Admin_Empresa\Admin_HomeWeb_Controllers@get_img_home',
  'as'    => 'get_img_home'
]);

Route::patch('edit_img_home/{id}',
[
  'uses'  => 'Admin_Empresa\Admin_HomeWeb_Controllers@edit_img_home',
  'as'    => 'edit_img_home'
]);

Route::delete('delet_img_home{id}',
[
  'uses'  => 'Admin_Empresa\Admin_HomeWeb_Controllers@delet_img_home',
  'as'    => 'delet_img_home'
]);