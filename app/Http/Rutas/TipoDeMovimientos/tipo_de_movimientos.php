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

