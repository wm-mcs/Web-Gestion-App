<?php



Route::post('editar_servicio_a_socio',
[
  'uses'       => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@editar_servicio_a_socio',
  'as'         => 'editar_servicio_a_socio']);  



Route::post('borrar_servicio_de_socio',
[
  'uses'       => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@borrar_servicio_de_socio',
  'as'         => 'borrar_servicio_de_socio']);  