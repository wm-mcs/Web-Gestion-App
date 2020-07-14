 {!! Form::open(             ['route'  => 'register_post',
                            'method'   => 'post',
                            'files'    => true,
                            'id'       => 'form-registro'
                            ])               !!}


  
            
            <div class="form-group">
              <label for="username" class="cols-sm-2 control-label">Nombre de usuario</label>
              <div class="cols-sm-10">
                <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-user" aria-hidden="true"></i></span>
                   {!! Form::text('name', null ,['class'       => 'form-control',
                                                 'id'          => 'username',
                                                 'placeholder' => 'Escribe tu nombre y apellido',
                                                 'required'    => 'required',
                                                 'data-error'  => 'Por favor, ingresa tu nombre.']) !!}
                                                 
                </div>
                <div class="help-block with-errors"></div> 

              </div>
            </div>

            <div class="form-group">
              <label for="email" class="cols-sm-2 control-label">Dirección de correo</label>
              <div class="cols-sm-10">
                <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-envelope" aria-hidden="true"></i></span>
                  {!! Form::text('email', null ,['class'       => 'form-control',
                                                 'id'          => 'username',
                                                 'placeholder' => 'Escribe tu email',
                                                 'required'    => 'required',
                                                 'data-error'  => 'Por favor, ingresa tu email.']) !!}
                                                     
                </div>
                <div class="help-block with-errors"></div>
              </div>
            </div>

            <div class="form-group">
              <label for="password" class="cols-sm-2 control-label">Contraseña</label>
              <div class="cols-sm-10">
                <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-lock" aria-hidden="true"></i></span>
                  {!! Form::password('password', [ 'class'       => 'form-control',
                                                   'id'          => 'password',
                                                   'placeholder' => 'Escribe tu contraseña',
                                                   'required'    => 'required',
                                                   'data-error'  => 'Por favor, escribe tu contraseña.']) !!}
                </div>
                <div class="help-block with-errors"></div>
              </div>
            </div>

            <div class="form-group">
              <label for="confirm" class="cols-sm-2 control-label">Confirmar contraseña</label>
              <div class="cols-sm-10">
                <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-ok" aria-hidden="true"></i></span>
                  {!! Form::password('password_confirmation', [ 'class'       => 'form-control',
                                                   'id'          => 'password',
                                                   'placeholder' => 'Escribe tu contraseña de nuevo']) !!}
                </div>
              </div>
            </div>

            <div class="form-group ">
              <button type="submit" class="btn btn-primary btn-lg login-button">Registrarse</button>
            </div>
  <hr>
            <div class="login-register">
               <a href="{{route('auth_login_get')}}">Ya estoy registrado</a>
            </div>

{!! Form::close() !!}