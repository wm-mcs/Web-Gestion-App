{!! Form::open( ['route' => 'password_recet_post',
                            'method'   => 'Post',
                            'files'    => true
                            ])               !!}

          

            <h1><span class="icon-lock_open"></span> Recuperar contraseña</h1>

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


    

             
           
           
             <input type="submit" class="btn btn-primary btn-lg btn-block" value="Enviar Contraseña Reset Link" >

             
               

                
              

          {!! Form::close() !!}