<div class="formulario-label-fiel">
  {!! Form::label('reserva_de_clase_dias_por_adelantado', '¿Con cuántos días con anticipación deja reservar a los socios?', array('class' => 'formulario-label ')) !!}
  {!! Form::select('reserva_de_clase_dias_por_adelantado',[1 => '1 día',
                             2 => '2 días',
                             3 => '3 días',
                             4 => '4 días'] , null ,['class' => 'formulario-field'] )          !!}
</div>


<div class="formulario-label-fiel">
  {!! Form::label('reserva_de_clase_acepta_deuda', '¿Deja reservar estan debiendo?', array('class' => 'formulario-label ')) !!}
  {!! Form::select('reserva_de_clase_acepta_deuda',['si' => 'Si',
                             'no' => 'No'] , null ,['class' => 'formulario-field'] )          !!}
</div>

<div class="formulario-label-fiel">
  {!! Form::label('reserva_de_clase_acepta_sin_plan', '¿Deja reservar aunque no tenga nada contratado?', array('class' => 'formulario-label ')) !!}
  {!! Form::select('reserva_de_clase_acepta_sin_plan',['si' => 'Si',
                             'no' => 'No'] , null ,['class' => 'formulario-field'] )          !!}
</div>
