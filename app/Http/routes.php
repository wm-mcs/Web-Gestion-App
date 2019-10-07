<?php


// Authentication routes...
require __DIR__ . '/Rutas/Auth.php';



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
    
    //usuario verificado
    Route::group(['middleware' => 'verificad'],function()
    {
         require __DIR__ . '/Rutas/Usuarios_Verificados.php'; 


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
});


