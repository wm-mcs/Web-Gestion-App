<?php


// A u t h  
require __DIR__ . '/Rutas/Auth.php';

Route::get('email_simples' , [                    
     'uses' => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@email_simples',
     'as'   => 'email_simples']
    );


/**
 * Routas para compartir data entre webs
 */
Route::group(['middleware' => 'ApiPublica'],function()
{  
    require __DIR__ . '/Rutas/Api.php';
});


Route::group(['middleware' => 'auth'],function()
{

    //home
    Route::get('/' , [                    
     'uses' => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@get_home',
     'as'   => 'get_home']
    );
    
        //user cambio de contraseña
        Route::post('cambiarContraseñaUser',
        [
          'uses'  => 'Admin_Empresa\Admin_Users_Controllers@cambiarContraseñaUser',
          'as'    => 'cambiarContraseñaUser'
        ]);

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


