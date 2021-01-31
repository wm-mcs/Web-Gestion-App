<div class="formulario-label-fiel">
  {!! Form::label('control_acceso', '¿Control de acceso activo?', array('class' => 'formulario-label ')) !!}
  {!! Form::select('control_acceso',['si' => 'Si',
                             'no' => 'No'] , null ,['class' => 'formulario-field'] )          !!}
</div>