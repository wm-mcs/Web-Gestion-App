
$(document).ready(function(){
 


$('.Seccion_clientes_slider').flickity({
  // options
  cellSelector: '.Seccion_clientes_slider_elementos',
  contain: true,
  // disable previous & next buttons and dots
  prevNextButtons: true,
  pageDots: true,
  groupCells: true,
  lazyLoad: 2
});



$('.producto-individual-contenedor-imgs').flickity({
  // options
  cellSelector: '.producto-individual-img-contendor',
  contain: true,
  // disable previous & next buttons and dots
  prevNextButtons: true,
  pageDots: true,
  groupCells: true,
  lazyLoad: 2
});












 
});

