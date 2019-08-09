<?php 

//Productos
Route::get('/productos' , [                    
  'uses' => 'Publicas\Paginas_Controller@get_pagina_productos_listado',
  'as'   => 'get_pagina_productos_listado']
);
     //Noticia Individual
      Route::get('/{name}/{id}' , [                    
        'uses' => 'Publicas\Paginas_Controller@get_pagina_producto_individual',
        'as'   => 'get_pagina_producto_individual']
      );