<div class="admin-marca-lista-contenedor">
   
   <img class="admin-marca-img" src="{{$proyecto->url_img}}">
  
   <div class="admin-marca-contnedor-datos">
     
     <div class="admin-user-name-y-mas">
       <div class="admin-lista-dato-primario"> {{$proyecto->name}}</div>
            
       
     </div>
     <div class="admin-user-lista-contenedor-acciones">
        <a href="{{route('get_admin_proyectos_editar', $proyecto->id)}}">
          <span class="boton-acciones-editar">
            <span class="icon-create"> </span> 
          </span>
        </a>
     </div>
      
   
   </div>
   
  
</div>