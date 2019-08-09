  

 /* Aqui creo esta funcion para cambiar a entidades 
  de html el contenido del blog que viene de la base 
  de datos con html pero en texto plano*/

  var contenedor_noticia = $( "#contenido-noticia" ),
  str = contenedor_noticia.text(),
  html = $.parseHTML( str ),
  nodeNames = [];
 
  

  //borro el contenido
  contenedor_noticia.text( '' );

  //agrego el contenido
  contenedor_noticia.append( html );