<div class="admin-entidad-contenedor-imagenes-y-form">
   @foreach($Entidad->marcasevento as $img)
    <div class="admin-entidad-proyecto-img-adicionales-contenedor">
      <img class="admin-entidad-proyecto-img-adicionales" src="{{$img->marca->url_img}}">
      <a href="{{route('delete_admin_marca_eventos',$img->id)}}" class="icono-eleminar-imagen"><span class="icon-clear" ></span></a>
    </div>    
   @endforeach
</div>