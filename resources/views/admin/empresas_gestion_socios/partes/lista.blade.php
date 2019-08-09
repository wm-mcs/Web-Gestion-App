@if($marca->estado != 'si')
 <div class="admin-marca-lista-contenedor admin-marca-lista-contenedor-desactivado">
@else
 <div class="admin-marca-lista-contenedor">
@endif


   
   <img class="admin-marca-img" src="{{$marca->url_img}}">
  
   <div class="admin-marca-contnedor-datos">
     <div>
        {{-- quito la fecha --}}
        {{-- <div class="admin-marca-fecha">{{$marca->created_at->format('d-m-Y')}}</div>  --}}    
        <div class="admin-marca-titulo"> {{$marca->name}}      </div>
     </div>
     <div class="admin-user-lista-contenedor-acciones">
        <a href="{{$marca->route_admin}}">
          <span class="boton-acciones-editar">
           <i class="fas fa-edit"></i> 
          </span>
        </a>
     </div>
   </div>
   
  
</div>