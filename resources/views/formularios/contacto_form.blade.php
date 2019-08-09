

  {!! Form::open(             ['route' => 'post_contacto_form',
                            'method'   => 'post',
                            'files'    => true,
                            'id'       => 'contact-form'
                            ])               !!}


<div id="contacto-form">

    <div class="messages"></div>

    <div class="controls">

        <div class="row">

            <div class="col-sm-6">
                <div class="form-group">                    
                    {!! Form::label('name', 'Nombre') !!}
                    {!! Form::text('name', null ,['class'       => 'form-control',
                                                  'placeholder' => 'Escribe aquí tu nombre' ,
                                                  'required'    => 'required',
                                                  'data-error'  => 'Por favor, ingresa tu nombre.']) !!}
                <div class="help-block with-errors"></div>    
                </div>
                
            </div>  

            <div class="col-sm-6">
                <div class="form-group">                    
                    {!! Form::label('name', 'Empresa') !!}
                    {!! Form::text('name', null ,['class'       => 'form-control',
                                                  'placeholder' => 'Escribe aquí el nombre de tu empresa' ,
                                                  'required'    => 'required',
                                                  'data-error'  => 'Por favor, ingresa el nombre de tu empresa.']) !!}
                <div class="help-block with-errors"></div>    
                </div>
                
            </div>       
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">                    
                    {!! Form::label('email', 'Email') !!}
                    {!! Form::text('email', null ,['class'       => 'form-control',
                                                  'placeholder' => 'Escribe aquí una dirección de correo' ,
                                                  'required'    => 'required',
                                                  'data-error'  => 'Por favor, ingresa una dirección de correo válida.']) !!}
                <div class="help-block with-errors"></div>   
                </div>
                
            </div>
            <div class="col-sm-6">
                <div class="form-group">                    
                    {!! Form::label('telefono', 'Teléfono') !!}
                    {!! Form::text('telefono', null ,['class'       => 'form-control',
                                                      'placeholder' => 'Escribe aquí un número para contactarte',
                                                      'required'    => 'required',
                                                      'data-error'  => 'Por favor, ingresa un número para contactarte.']) !!}

                <div class="help-block with-errors"></div>    
                </div>
                
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group"> 
                    {!! Form::label('mensaje', 'Mensaje') !!}
                    {!! Form::textarea('mensaje', null ,['class'       => 'form-control',
                                                         'placeholder' => 'Escribe tu consulta aquí', 
                                                         'rows'        => '4',
                                                         'required'    => 'required',
                                                         'data-error'  => 'Por favor, escribe un mensaje.' ]) !!}
                <div class="help-block with-errors"></div>    
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <input type="submit" class="btn btn-primary btn-lg btn-send" value="Enviar">
            </div>
        </div>

        </div>

    </div>



{!! Form::close() !!}
