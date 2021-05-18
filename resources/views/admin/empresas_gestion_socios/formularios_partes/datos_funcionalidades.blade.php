<div class="formulario-label-fiel">
  {!! Form::label('control_acceso', '¿Control de acceso activo?', array('class' => 'formulario-label ')) !!}
  {!! Form::select('control_acceso',['si' => 'Si',
                             'no' => 'No'] , null ,['class' => 'formulario-field'] )          !!}
</div>

<div class="formulario-label-fiel">
  {!! Form::label('reserva_de_clases_on_line', '¿Reserva de clases online activa?', array('class' => 'formulario-label ')) !!}
  {!! Form::select('reserva_de_clases_on_line',['si' => 'Si',
                             'no' => 'No'] , null ,['class' => 'formulario-field'] )          !!}
</div>
<div class="formulario-label-fiel">
  {!! Form::label('grupos', '¿Acepta grupos?', array('class' => 'formulario-label ')) !!}
  {!! Form::select('grupos',['si' => 'Si',
                             'no' => 'No'] , null ,['class' => 'formulario-field'] )          !!}
</div>
