

<avisos-empresa-admin :admin="true"></avisos-empresa-admin>

<div class="formulario-label-fiel">
  {!! Form::label('mensajes_sistema', '¿Se puede enviar mensajes del sistema?', array('class' => 'formulario-label ')) !!}
  {!! Form::select('mensajes_sistema',['si' => 'Si',
                             'no' => 'No'] , null ,['class' => 'formulario-field'] )          !!}
</div>

<div class="formulario-label-fiel">
  {!! Form::label('mensajes_publicidad', '¿Se puede enviar mensajes publicitarios?', array('class' => 'formulario-label ')) !!}
  {!! Form::select('mensajes_publicidad',['si' => 'Si',
                             'no' => 'No'] , null ,['class' => 'formulario-field'] )          !!}
</div>
