<div class="admin-marca-lista-contenedor">
   
   <img class="admin-marca-img" src="{{$Entidad->url_img_portada_chica}}">
  
   <div class="admin-marca-contnedor-datos">
     
     <div class="admin-user-name-y-mas">
       <div class="admin-lista-dato-primario"> {{$Entidad->name}}</div>      
     </div>
     <div class="admin-user-lista-contenedor-acciones">
        <a href=" {{$Entidad->route_admin}}">
          <span class="boton-acciones-editar">
            <i class="fas fa-edit"></i> 
          </span>
        </a>
     </div>
      
   
   </div>
   
  
</div>