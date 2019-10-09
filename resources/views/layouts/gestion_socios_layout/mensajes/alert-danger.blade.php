@if(Session::has('alert-danger'))
  <div class="mensajes-contenedor ocultar-esto alert-dager">

    {{ Session::get('alert-danger') }}

    <span class="mensaje-cerrar-icono">
       <i class="fas fa-times"></i>
    </span> 
  </div>
@endif