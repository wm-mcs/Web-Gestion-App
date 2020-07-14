{!! Form::open( ['route' => 'password_recet_post',
                            'method'   => 'Post',
                            'files'    => true
                            ])               !!}

          

           

             <div class="form-group">
              
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