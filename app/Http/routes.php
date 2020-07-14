<?php


// A u t h  
require __DIR__ . '/Rutas/Auth.php';

Route::get('email_simples' , [                    
     'uses' => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@email_simples',
     'as'   => 'email_simples']
    );



// R o u t a s   p a r a   c o m p a r t i r   d a t a   e n t r e   w e b s 
Route::group(['middleware' => 'ApiPublica'],function()
{  
    require __DIR__ . '/Rutas/Api.php';
});


Route::group(['middleware' => 'auth'],function()
{

    // H o m e  d e  l a  A P P
    Route::get('/' , [                    
     'uses' => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@get_home',
     'as'   => 'get_home']
    );
    
        // U s e r  c a m b i o   d e   c o n t r a s e ñ a 
        Route::post('cambiarContraseñaUser',
        [
          'uses'  => 'Admin_Empresa\Admin_Users_Controllers@cambiarContraseñaUser',
          'as'    => 'cambiarContraseñaUser'
        ]);

        // A d m i n   R u t a s 
        Route::group(['middleware' => 'SistemaGestionUserGerarquia:2'], function()
        {
             require __DIR__ . '/Rutas/Admin_Empresa_Cliente.php';

             // A d m i n   m á x i m o 
             Route::group(['middleware' => 'SistemaGestionUserGerarquia:10'], function()
             {
               require __DIR__ . '/Rutas/Admin_Supremo.php';
             });
        });
    
});


