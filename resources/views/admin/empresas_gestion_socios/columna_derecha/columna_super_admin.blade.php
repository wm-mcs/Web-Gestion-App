 
@if(Auth::user()->role >= 7)
 <ul class="empresa-contendor-de-secciones">

    <span class="empresa-titulo-de-secciones">Super admin</span>  
    <a href="{{route('get_admin_users')}}" class="columna-lista-texto">
     <i class="fas fa-user"></i> Usuarios
    </a>
    <a href="{{route('get_admin_empresas_gestion_socios')}}" class="columna-lista-texto">
      <i class="fas fa-bars"></i> Empresas gestión
    </a>
    <a href="route{{route('get_tipo_de_movimeintos_index')}}">Tipos de movimientos </a>

    <tipo-de-servicios-empresa></tipo-de-servicios-empresa>
    <paises></paises>
   

</ul>


@endif

   