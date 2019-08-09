<?php


// Authentication routes...
require __DIR__ . '/Rutas/Auth.php';

// Authentication routes...
require __DIR__ . '/Rutas/Publicas.php';

/**
 * Grupo de Rutas con middleware
 */
Route::group(['middleware' => 'auth'],function()
{
    //usuario verificado
    Route::group(['middleware' => 'verificad'],function()
    {
         require __DIR__ . '/Rutas/Usuarios_Verificados.php'; 


         //admin_empresa_clientes
         Route::group(['middleware' => 'role:admin_empresa'], function()
         {
           require __DIR__ . '/Rutas/Admin_Empresa_Cliente.php';

                 //admin_nuestro
                 Route::group(['middleware' => 'role:adminMcos522'], function()
                 {
                   require __DIR__ . '/Rutas/Admin_Supremo.php';
                 });
         });
    });
});


