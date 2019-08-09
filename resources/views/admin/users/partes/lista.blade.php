<div class="admin-user-lista-contenedor">
   <div class="admin-user-lista-icono">
     <i class="fas fa-user"></i>
   </div>
   <div class="admin-user-contenedor-datos">
     <div class="admin-user-name-y-mas">
       <div class="admin-lista-dato-primario"> {{$user->name}}</div>
       <div class="admin-lista-dato-secundario"><span class="icon-call"></span> {{$user->telefono}}</div>
       <div class="admin-lista-dato-secundario"><span class="icon-markunread"></span> {{$user->email}}</div>
       @include('admin.users.partes.condicion_role')
       @include('admin.users.partes.condicion_activo')
     </div>
     <div class="admin-user-lista-contenedor-acciones">
        <a href="{{route('get_admin_users_editar', $user->id)}}">
          <span class="boton-acciones-editar">
            <i class="fas fa-edit"></i> 
          </span>
        </a>
     </div>
      
   </div>
  
</div>