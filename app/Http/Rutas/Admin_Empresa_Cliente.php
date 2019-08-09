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
    require __DIR__ . '/Empresa_Gestion_Socios/Rutas_Empresa_Gestion.php';
});






