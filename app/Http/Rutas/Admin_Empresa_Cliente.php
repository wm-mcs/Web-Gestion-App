<?php
 
      require __DIR__ . '/Empresa_Gestion_Socios/Rutas_Empresa_Gestion.php';

      Route::group(['middleware' => 'SistemaGestionEmpresaIgualVendedorEmpresa'],function()
      {
           Route::group(['middleware' => 'SistemaGestionUserGerarquia:4'], function()
           {
                Route::post('get_panel_admin_de_empresa',
                [
                  'uses'       => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Admin_Vendedores_Controllers@get_panel_admin_de_empresa',
                  'as'         => 'get_panel_admin_de_empresa']);

                Route::post('ingresar_movimiento_a_empresa',
                [
                  'uses'       => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Admin_Vendedores_Controllers@ingresar_movimiento_a_empresa',
                  'as'         => 'ingresar_movimiento_a_empresa']); 

                 Route::post('eliminar_estado_de_cuenta_empresa',
                [
                  'uses'       => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Admin_Vendedores_Controllers@eliminar_estado_de_cuenta_empresa',
                  'as'         => 'eliminar_estado_de_cuenta_empresa']); 

                 Route::post('editar_servicio_renovacion_empresa',
                [
                  'uses'       => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Admin_Vendedores_Controllers@editar_servicio_renovacion_empresa',
                  'as'         => 'editar_servicio_renovacion_empresa']); 

                Route::post('agregar_servicio_a_empresa',
                [
                  'uses'       => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Admin_Vendedores_Controllers@agregar_servicio_a_empresa',
                  'as'         => 'agregar_servicio_a_empresa']); 

                Route::post('editar_servicio_a_empresa',
                [
                  'uses'       => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Admin_Vendedores_Controllers@editar_servicio_a_empresa',
                  'as'         => 'editar_servicio_a_empresa']); 

                Route::post('borrar_servicio_de_empresa',
                [
                  'uses'       => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Admin_Vendedores_Controllers@borrar_servicio_de_empresa',
                  'as'         => 'borrar_servicio_de_empresa']);                 

           });

      });  



      Route::group(['middleware' => 'SistemaGestionEmpresaIgualUserEmpresa'],function()
      {
          require __DIR__ . '/Empresa_Gestion_Socios/Rutas_Empresa_Gestion_Empresa_Igual_User_empresa_Midelware.php'; 

          Route::group(['middleware' => 'SistemaGestionUserEmpresIgualSucursalEmpresa'],function()
          {     
                //Para ir al panel de la empresa vista del cliente
                Route::post('get_empresa_panel_de_gestion',
                [
                  'uses'       => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@get_empresa_panel_de_gestion',
                  'as'         => 'get_empresa_panel_de_gestion']);  

                Route::post('actuliarServiciosDeManeraAutomatica',
                [
                  'uses'       => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@actuliarServiciosDeManeraAutomatica',
                  'as'         => 'actuliarServiciosDeManeraAutomatica']);  

                //cambiar de sucursal
                Route::post('cambiar_de_sucursal',
                [
                  'uses'       => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@cambiar_de_sucursal',
                  'as'         => 'cambiar_de_sucursal']);  

                //ingresar_movimiento_de_caja
                Route::post('ingresar_movimiento_caja',
                [
                  'uses'       => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@ingresar_movimiento_caja',
                  'as'         => 'ingresar_movimiento_caja']);
                
                 //eliminar el moviiento de caja
                Route::post('eliminar_estado_de_caja',
                [
                  'uses'       => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@eliminar_estado_de_caja',
                  'as'         => 'eliminar_estado_de_caja']);

                Route::post('get_movimientos_de_caja_de_sucursal',
                [
                 'uses'       => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@get_movimientos_de_caja_de_sucursal',
                 'as'         => 'get_movimientos_de_caja_de_sucursal']);   

                Route::group(['middleware' => 'SistemaGestionUserEmpresIgualSociaEmpresa'],function()
                {
                  require __DIR__ . '/Empresa_Gestion_Socios/Rutas_Empresa_Gestion_Socio_Empresa_Igual_User_empresa_Midelware.php';
                });
          });
         


      });