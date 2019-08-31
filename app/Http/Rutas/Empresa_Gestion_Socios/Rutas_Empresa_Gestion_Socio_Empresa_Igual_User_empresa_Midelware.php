<?php




Route::post('borrar_servicio_de_socio',
[
  'uses'       => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@borrar_servicio_de_socio',
  'as'         => 'borrar_servicio_de_socio']);  