{!! Form::open(             ['route' => 'auth_login_post',
                            'method'   => 'post',
                            'files'    => true
                            ])               !!}

            
<div class="text-center">
  <div class="center-block">
      <div class="form-group">
        <div class="cols-sm-10">
          <div class="input-group"> 
            {!! Form::text('email', null ,['class'       => 'input-text-class-primary',
                                           'id'          => 'username',
                                           'placeholder' => 'Escribe tu email']) !!}
          </div>
        </div>
      </div>
      <div class="form-group">              
        <div class="cols-sm-10">
          <div class="input-group">                                
            {!! Form::password('password', [ 'class'       => 'input-text-class-primary',
                                             'id'          => 'password',
                                             'placeholder' => 'Escribe tu contraseña']) !!}
          </div>
        </div>
      </div>
      <div class="form-group ">
        <button type="submit" class="Boton-Primario-Relleno Boton-Fuente-Chica">Ingresar</button>
      </div>
     <hr>
     <div class="login-register">
       <p class="text-center m-0"><a href="{{route('password_recet_get')}}">Olvidé mi contraseña</a></p>
     </div>   
  </div>
</div>



{!! Form::close() !!}


