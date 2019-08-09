<div class="admin-user-lista-contenedor">
   <div class="admin-user-lista-icono">
     <img  class="img-home-lista-contenedor" src="{{$Imagen->url_img}}">
   </div>
   <div class="admin-user-contenedor-datos">
     <div class="admin-user-name-y-mas">
       <div class="admin-lista-dato-primario"> {{$Imagen->name}}</div>
       <div class="admin-lista-dato-secundario">{{$Imagen->description}}</div>
       
     </div>
     <div class="admin-user-lista-contenedor-acciones">
        <a href="{{route('get_img_home',$Imagen->id)}}">
          <span class="boton-acciones-editar">
            <span class="icon-create"></span> 
          </span>
        </a>
     </div>
      
   </div>  
</div>