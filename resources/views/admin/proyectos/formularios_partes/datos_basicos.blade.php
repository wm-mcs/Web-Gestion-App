<div class="formulario-label-fiel">
  {!! Form::label('name', 'Nombre', array('class' => 'formulario-label ')) !!}
  {!! Form::text('name', null ,['class' => 'formulario-field']) !!}
</div>

<div class="formulario-label-fiel">
  {!! Form::label('description', 'Descripción', array('class' => 'formulario-label ')) !!}
  {!! Form::textarea('description', null ,['class' => 'formulario-field',
                                           'cols'    => '8',
                                           'row'    => '8' ]) !!}
</div>

<div class="formulario-label-fiel">
  {!! Form::label('fecha', 'Fecha', array('class' => 'formulario-label ')) !!}
  {!! Form::text('fecha', null ,['class' => 'formulario-field']) !!}
</div>

<div class="formulario-label-fiel">
  {!! Form::label('ubicacion', 'Ubicación', array('class' => 'formulario-label ')) !!}
  {!! Form::text('ubicacion', null ,['class' => 'formulario-field']) !!}
</div>

<div class="formulario-label-fiel">
  {!! Form::label('metodo_de_construccion', 'Metodo de construcción', array('class' => 'formulario-label ')) !!}
  {!! Form::text('metodo_de_construccion', null ,['class' => 'formulario-field']) !!}
</div>

<div class="formulario-label-fiel">
  {!! Form::label('autores', 'Autores', array('class' => 'formulario-label ')) !!}
  {!! Form::text('autores', null ,['class' => 'formulario-field']) !!}
</div>



