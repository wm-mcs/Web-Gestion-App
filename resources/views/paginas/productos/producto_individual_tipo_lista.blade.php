<a href="{{$Entidad->route}}" class="get_width_100">
<div class="producto-lista-contenedor">

<div class="producto-lista-contiene-img">
  
    <img data-src="{{$Entidad->url_img}}" class="producto-lista-img">
  
</div>

<div class="producto-lista-contiene-name">

  <div class="producto-lista-name color-text-gris"> {{$Entidad->name}} </div>
  
  
</div>


<div class="producto-lista-contiene-precio">
  <div class="producto-lista-precio ">  <span class="helper-reduce-texto">{{$Entidad->moneda}} </span> {{$Entidad->precio_producto}}</div>
  @if($Entidad->stock > 0)
    <div class="text-center color-text-success helper-reduce-texto">
        Entrega inmediata <i class="fas fa-check"></i>
    </div>

  @else
    <div class="text-center color-text-gris helper-reduce-texto "> 
        Disponible en 24hs  <i class="far fa-clock"></i>
    </div>
  @endif

</div>
  


  
</div>
</a>