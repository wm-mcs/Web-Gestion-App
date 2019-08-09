


<div class="estilo-texto-general">
  
  {{ $user->name}}, parece que has olvidado tu contraseña. De ser así, haz click en el siguiente botón para restablecerla.

</div>

 <br>
 <br>
 <a  href="{{ route('password_recet_route_get',$token)  }}"> 
   <div class="botonEmails">Restablecer contraseña</div> 
 </a> 

