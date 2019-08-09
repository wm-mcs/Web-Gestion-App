<?php 

//Noticias
Route::get('/blog' , [                    
  'uses' => 'Publicas\Paginas_Controller@get_pagina_noticias_listado',
  'as'   => 'get_pagina_noticias_listado']
);
     //Noticia Individual
      Route::get('/Publicacion/{name}/{id}' , [                    
        'uses' => 'Publicas\Paginas_Controller@get_pagina_noticia_individual',
        'as'   => 'get_pagina_noticia_individual']
      );