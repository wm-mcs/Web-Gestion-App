@if(!Auth::guest())
	@if(!Auth::user()->registration_token == NULL)

	  <div class="alerta_contenedor">
	              
	              <div class="Alert-Titulo">
	                <span class="icon-warning"></span>
	                {{Auth::user()->first_name}} te enviamos un email a <strong>{{Auth::user()->email}}</strong> para que verifiques tu cuenta. En caso de que no lo hayas recibido <a href="{{route('reenvioEmailConfirmacion')}}">click aquí para que te enviemos de nuevo</a> . Si el email mencionado anteriormente este incorrecto <a href="{{route('register_get')}}">Registrate de Nuevo Aquí</a>.
	              </div>
	              <div class="alerta-iconoCerrar">
	                <i class="fas fa-times"></i>
	              </div>
	 </div>


	@endif
@endif