<?php 

Route::get('get_tipo_de_movimeintos_index',
[
  'uses'  => 'Admin_Empresa\TipoDeMovimientoController@getIndex',
  'as'    => 'get_tipo_de_movimeintos_index'
]);

