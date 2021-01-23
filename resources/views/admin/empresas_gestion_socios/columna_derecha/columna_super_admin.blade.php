 
@if(Auth::user()->role >= 7)
 <ul class="empresa-contendor-de-secciones">

    <p class="color-text-gris mb-3">
       <small>Administrador</small> 
    </p> 
    <li class="parrafo-class mb-1">
     <a href="{{route('get_admin_users')}}" >
       <small>Usuarios</small> 
     </a>
    </li>
    <li class="parrafo-class mb-1">
     <a href="{{route('get_admin_empresas_gestion_socios')}}" >
       <small>Empresas</small> 
     </a>
    </li>
    <li class="parrafo-class mb-1">
     <a href="{{route('get_tipo_de_movimeintos_index')}}" >
       <small>Tipos de movimientos</small> 
     </a>
    </li>
    <li class="parrafo-class mb-1">
     <a href="{{route('get_paises_index')}}" >
       <small>Paises</small> 
     </a>
    </li>
   
  
   

    {{-- <tipo-de-servicios-empresa></tipo-de-servicios-empresa>
    <paises></paises> --}}
   

</ul>


@endif

   