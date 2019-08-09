<?php 

//Marcas
Route::get('/Clientes' , [                    
  'uses' => 'Publicas\Paginas_Controller@get_pagina_marcas',
  'as'   => 'get_pagina_marcas']
); 


Route::get('/eventos-de-{name}-{id}' , [                    
  'uses' => 'Publicas\Paginas_Controller@get_pagina_marca_individual',
  'as'   => 'get_pagina_marca_individual']
);