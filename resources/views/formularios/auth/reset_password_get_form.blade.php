 {!! Form::open( ['route' => 'password_recet_route_post',
                            'method'   => 'Post',
                            'files'    => true
                            ])               !!}

          
            {{-- toquenoculto --}}
            <input type="hidden" name="token" value="{{ $token }}">                
            <h1 class="Titulo-Auth">
             <span class="icon-lock_open"></span> Nueva Contraseña</h1>


             <div class="form-group">
              <label for="username" class="cols-sm-2 control-label">Email</label>
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
                                                   'placeholder' => 'Escribe una nueva contraseña']) !!}
                </div>
              </div>
            </div>

            <div class="form-group">
              <label for="password" class="cols-sm-2 control-label">Confirmar contraseña</label>
              <div class="cols-sm-10">
                <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-lock" aria-hidden="true"></i></span>                
                  {!! Form::password('password_confirmation', [ 'class'       => 'form-control',
                                                   'id'          => 'password',
                                                   'placeholder' => 'Confirma la nueva contraseña']) !!}
                </div>
              </div>
            </div>








            
           
            

             
           
           
             <input type="submit" class="btn btn-primary btn-lg btn-block" value="Resetear Contraseña" >

             
               

                
              

          {!! Form::close() !!}