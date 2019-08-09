

  {!! Form::open(             ['route' => 'auth_login_post',
                            'method'   => 'post',
                            'files'    => true
                            ])               !!}

            
<div class="text-center">
<div class="center-block">
            <div class="form-group">
              <label for="username" class="cols-sm-2 control-label">Usuario</label>
              <div class="cols-sm-10">
                <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-user" aria-hidden="true"></i></span>
                  
                  {!! Form::text('email', null ,['class'       => 'form-control',
                                                 'id'          => 'username',
                                                 'placeholder' => 'Escribe tu email']) !!}
                </div>
              </div>
            </div>

            <div class="form-group">
              <label for="password" class="cols-sm-2 control-label">Contraseña</label>
              <div class="cols-sm-10">
                <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-lock" aria-hidden="true"></i></span>                
                  {!! Form::password('password', [ 'class'       => 'form-control',
                                                   'id'          => 'password',
                                                   'placeholder' => 'Escribe tu contraseña']) !!}
                </div>
              </div>
            </div>

            <div class="form-group ">
              <button type="submit" class="btn btn-primary btn-lg btn-block">Ingresar</button>
            </div>
            
<div class="checkbox">
  <label>
    <input type="checkbox" value="">
    Recordar mi usuario
  </label>
</div>

    <hr>
   <div class="login-register">
                    <p class="text-center"><a href="{{route('password_recet_get')}}">Olvidé mi contraseña</a><!--  | <a href="{{route('register_get')}}">Aún no estoy registrado</a> --></p>
   </div>
   
</div>
</div>



{!! Form::close() !!}


