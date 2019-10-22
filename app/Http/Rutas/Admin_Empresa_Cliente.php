<?php


Route::group(['middleware' => 'SistemaPaginaWeb'],function()
{
    require __DIR__ . '/Empresa/Rutas_Empresa.php';

    

    require __DIR__ . '/Home/Rutas_Home.php'; 

    require __DIR__ . '/Productos/Rutas_Productos.php'; 

    require __DIR__ . '/Marcas/Rutas_Marcas.php';

    require __DIR__ . '/Noticias/Rutas_Noticias.php';

    require __DIR__ . '/Categorias/Rutas_Categorias.php';
}); 





 

 
      require __DIR__ . '/Empresa_Gestion_Socios/Rutas_Empresa_Gestion.php';



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


                //cambiar de sucursal
                Route::post('cambiar_de_sucursal',
                [
                  'uses'       => 'Admin_Empresa\Admin_Empresa_Gestion_Socios_Controllers@cambiar_de_sucursal',
                  'as'         => 'cambiar_de_sucursal']);  



                 Route::group(['middleware' => 'SistemaGestionUserEmpresIgualSociaEmpresa'],function()
                 {
                  require __DIR__ . '/Empresa_Gestion_Socios/Rutas_Empresa_Gestion_Socio_Empresa_Igual_User_empresa_Midelware.php';
                 });
          });
         


      });

 







