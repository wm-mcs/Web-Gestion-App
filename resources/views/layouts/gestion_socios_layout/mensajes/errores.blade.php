 @if (count($errors) > 0)
  <div class="mensajes-contenedor ocultar-esto alert-dager">

    <span>Por favor corrige los siguientes errores:</span> 
    <ul class="Error-Ul">
        @foreach ($errors->all() as $error)
          <li class="Error-Li">{{ $error }}</li>
        @endforeach
    </ul> 

    <span class="mensaje-cerrar-icono">
       <i class="fas fa-times"></i>
    </span> 
  </div>
@endif


