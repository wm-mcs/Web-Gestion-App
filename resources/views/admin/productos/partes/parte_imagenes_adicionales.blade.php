<div class="admin-entidad-contenedor-imagenes-y-form">
   @foreach($Entidad->imagenes as $img)
    <div class="admin-entidad-proyecto-img-adicionales-contenedor 
      @if($img->foto_principal == 'si') admin-entidad-proyecto-img-adicionales-contenedor__show 
      @endif">
      <img class="admin-entidad-proyecto-img-adicionales" src="{{$img->url_img}}">
      <a href="{{route('delete_admin_productos_img',$img->id)}}" class="icono-eleminar-imagen"><i class="fas fa-trash"></i></a>
      @if($img->foto_principal != 'si')
        <a href="{{route('establecer_como_imagen_principal_producto',$img->id)}}" class="icono-establecer-imagen" title="Establecer como imagen principal">
        <i class="far fa-star"></i>
        </a>
      @else
        <span class="icono-establecer-imagen">
         <i class="fas fa-star"></i>
        </span>
         
       
      @endif

    </div>    
   @endforeach

   
</div>

