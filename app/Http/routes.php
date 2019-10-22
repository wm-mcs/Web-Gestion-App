<?php


// Authentication routes...
require __DIR__ . '/Rutas/Auth.php';

Route::get('email_simples' , [                    
     'uses' => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@email_simples',
     'as'   => 'email_simples']
    );

/**
 * Grupo de Rutas con middleware
 */
Route::group(['middleware' => 'auth'],function()
{

    //home
    Route::get('/' , [                    
     'uses' => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@get_home',
     'as'   => 'get_home']
    );
    
    
       


         //admin_empresa_clientes
         Route::group(['middleware' => 'SistemaGestionUserGerarquia:2'], function()
         {
                 require __DIR__ . '/Rutas/Admin_Empresa_Cliente.php';

                 //admin_nuestro
                 Route::group(['middleware' => 'SistemaGestionUserGerarquia:10'], function()
                 {
                   require __DIR__ . '/Rutas/Admin_Supremo.php';
                 });
         });
    
});


