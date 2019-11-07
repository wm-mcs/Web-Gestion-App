<?php 


 Route::group(['middleware' => 'SistemaGestionUserGerarquia:3'], function()
 {
         

          //llana mmo a los usuarios con el rol para asiganr a una empresa
          Route::post('get_user_rol_panel_gestion',
          [
            'uses'       => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@get_user_rol_panel_gestion',
            'as'         => 'get_user_rol_panel_gestion',                
          ]);

          // vinculo una empresa con un usuario
          Route::post('set_user_a_empresa',
          [
            'uses'       => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@set_user_a_empresa',
            'as'         => 'set_user_a_empresa',                
          ]);

          // vinculo una empresa con un usuario
          Route::post('delete_user_a_empresa',
          [
            'uses'       => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@delete_user_a_empresa',
            'as'         => 'delete_user_a_empresa',                
          ]);

          // creo sucursal
          Route::post('crear_sucursal',
          [
            'uses'       => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@crear_sucursal',
            'as'         => 'crear_sucursal',                
          ]);

          // edito sucursal
          Route::post('editar_sucursal',
          [
            'uses'       => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@editar_sucursal',
            'as'         => 'editar_sucursal',                
          ]);


          



          



          
          


           Route::group(['middleware' => 'SistemaGestionUserGerarquia:8'], function()
           {
                
                //Get Listado
                Route::get('get_admin_empresas_gestion_socios',
                [
                  'uses'       => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@get_admin_empresas_gestion_socios',
                  'as'         => 'get_admin_empresas_gestion_socios',                
                ]);


                //GET Crear
                Route::get('get_admin_empresas_gestion_socios_crear',
                [
                  'uses'       => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@get_admin_empresas_gestion_socios_crear',
                  'as'         => 'get_admin_empresas_gestion_socios_crear',            
                ]);

                Route::post('set_admin_empresas_gestion_socios_crear',
                [
                  'uses'            => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@set_admin_empresas_gestion_socios_crear',
                  'as'              => 'set_admin_empresas_gestion_socios_crear',            
                ]);


                //GET Editar
                Route::get('get_admin_empresas_gestion_socios_editar_{id}',
                [
                  'uses'       => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@get_admin_empresas_gestion_socios_editar',
                  'as'         => 'get_admin_empresas_gestion_socios_editar',
                  
                ]); 


                //Patch Editar
                Route::patch('set_admin_empresas_gestion_socios_editar_{id}',
                [
                  'uses'       => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@set_admin_empresas_gestion_socios_editar',
                  'as'         => 'set_admin_empresas_gestion_socios_editar',            
                ]);   


                // vinculo una vendedor con un usuario
                Route::post('set_vendedor_a_empresa',
                [
                  'uses'       => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@set_vendedor_a_empresa',
                  'as'         => 'set_vendedor_a_empresa',                
                ]);


                //
                Route::post('delete_vendedor_a_empresa',
                [
                  'uses'       => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@delete_vendedor_a_empresa',
                  'as'         => 'delete_vendedor_a_empresa',                
                ]); 
                

           });
         
 });


Route::get('get_tipo_servicios{empresa_id}',
[
  'uses'       => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@get_tipo_servicios',
  'as'         => 'get_tipo_servicios']);  























