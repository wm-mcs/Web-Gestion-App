<div class="formulario-label-fiel">
  {!! Form::label('actualizar_servicios_socios_automaticamente', '¿Se renuevan los servicios automáticamente?', array('class' => 'formulario-label ')) !!}
  {!! Form::select('actualizar_servicios_socios_automaticamente',['si' => 'Si',
                             'no' => 'No'] , null ,['class' => 'formulario-field'] )          !!}
</div>