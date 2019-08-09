<?php 


Route::get('get_admin_productos',
[
  'uses'  => 'Admin_Empresa\Admin_Producto_Controllers@get_admin_productos',
  'as'    => 'get_admin_productos'
]);

Route::get('get_admin_productos_crear',
[
  'uses'  => 'Admin_Empresa\Admin_Producto_Controllers@get_admin_productos_crear',
  'as'    => 'get_admin_productos_crear'
]);

Route::post('set_admin_productos',
[
  'uses'  => 'Admin_Empresa\Admin_Producto_Controllers@set_admin_productos',
  'as'    => 'set_admin_productos'
]);


Route::get('get_admin_productos_editar{id}',
[
  'uses'  => 'Admin_Empresa\Admin_Producto_Controllers@get_admin_productos_editar',
  'as'    => 'get_admin_productos_editar'
]); 


Route::patch('set_admin_productos_editar{id}',
[
  'uses'  => 'Admin_Empresa\Admin_Producto_Controllers@set_admin_productos_editar',
  'as'    => 'set_admin_productos_editar'
]);


Route::post('set_admin_productos_img{id}',
[
  'uses'  => 'Admin_Empresa\Admin_Producto_Controllers@set_admin_productos_img',
  'as'    => 'set_admin_productos_img'
]);

Route::get('establecer_como_imagen_principal_producto{id_img}',
[
  'uses'  => 'Admin_Empresa\Admin_Producto_Controllers@establecer_como_imagen_principal_producto',
  'as'    => 'establecer_como_imagen_principal_producto'
]); 

Route::get('delete_admin_productos_img{id_img}',
[
  'uses'  => 'Admin_Empresa\Admin_Producto_Controllers@delete_admin_productos_img',
  'as'    => 'delete_admin_productos_img'
]);  


