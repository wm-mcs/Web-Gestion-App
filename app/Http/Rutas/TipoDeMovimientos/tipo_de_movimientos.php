<?php 

Route::get('get_tipo_de_movimeintos_index',
[
  'uses'  => 'Admin_Empresa\TipoDeMovimientoController@getIndex',
  'as'    => 'get_tipo_de_movimeintos_index'
]);

Route::get('get_tipo_de_movimientos',
[
  'uses'  => 'Admin_Empresa\TipoDeMovimientoController@get_tipo_de_movimientos',
  'as'    => 'get_tipo_de_movimientos'
]);

Route::post('set_un_tipo_de_movimiento',
[
  'uses'  => 'Admin_Empresa\TipoDeMovimientoController@set_un_tipo_de_movimiento',
  'as'    => 'set_un_tipo_de_movimiento'
]);

Route::post('edit_un_tipo_de_movimiento',
[
  'uses'  => 'Admin_Empresa\TipoDeMovimientoController@edit_un_tipo_de_movimiento',
  'as'    => 'edit_un_tipo_de_movimiento'
]);





