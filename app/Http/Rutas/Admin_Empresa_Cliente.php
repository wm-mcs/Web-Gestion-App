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





Route::group(['middleware' => 'SistemaGestionSocios'],function()
{


 Route::group(['middleware' => 'SistemaGestionUserGerarquia:2'], function()
 {
    require __DIR__ . '/Empresa_Gestion_Socios/Rutas_Empresa_Gestion.php';



    Route::group(['middleware' => 'SistemaGestionEmpresaIgualUserEmpresa'],function()
    {
      require __DIR__ . '/Empresa_Gestion_Socios/Rutas_Empresa_Gestion_Empresa_Igual_User_empresa_Midelware.php';
    });

 });  






});






