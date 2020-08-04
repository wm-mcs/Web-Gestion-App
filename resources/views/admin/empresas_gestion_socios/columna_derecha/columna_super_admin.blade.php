 
@if(Auth::user()->role >= 7)
 <ul class="empresa-contendor-de-secciones">

    <p class="color-text-gris mb-3">
       <small>Administrador</small> 
    </p> 
    <li class="parrafo-class mb-1">
     <a href="{{route('get_admin_users')}}" >
       Usuarios
     </a>
    </li>
    <li class="parrafo-class mb-1">
     <a href="{{route('get_admin_empresas_gestion_socios')}}" >
       Empresas
     </a>
    </li>
    <li class="parrafo-class mb-1">
     <a href="{{route('get_tipo_de_movimeintos_index')}}" >
       Tipos de movimientos
     </a>
    </li>
   
  
   

    <tipo-de-servicios-empresa></tipo-de-servicios-empresa>
    <paises></paises>
   

</ul>


@endif

   