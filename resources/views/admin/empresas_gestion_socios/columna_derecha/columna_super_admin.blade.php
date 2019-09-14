 
@if(Auth::user()->role >= 7)
 <ul >
   <div class="admin-columna-ul-titulo">Super admin</div>
   <div >
        
        <a href="{{route('get_admin_users')}}">
          <li class="admin-columna-li mi-float-right"><i class="fas fa-user"></i> Usuarios</li>
        </a>
        

        
        <a href="{{route('get_admin_empresas_gestion_socios')}}">
          <li class="admin-columna-li mi-float-right"><i class="fas fa-bars"></i> Empresas gestión socios</li>
        </a>

        
        
    </div>

</ul>
@endif

   