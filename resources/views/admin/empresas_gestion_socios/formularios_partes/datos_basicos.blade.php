<div class="formulario-label-fiel">
  {!! Form::label('name', 'Nombre', array('class' => 'formulario-label ')) !!}
  {!! Form::text('name', null ,['class' => 'formulario-field']) !!}
</div>

<div class="formulario-label-fiel">
  {!! Form::label('email', 'Email para enviar facturas', array('class' => 'formulario-label ')) !!}
  {!! Form::text('email', null ,['class' => 'formulario-field']) !!}
</div>

<div class="formulario-label-fiel">
  {!! Form::label('celular', 'Celular', array('class' => 'formulario-label ')) !!}
  <div class="modal-mensaje-aclarador">
    Si la empresa es de fuera de Uruguay se debe poner todos los dígitos menos el simbolo de +.
  </div>
  {!! Form::text('celular', null ,['class' => 'formulario-field']) !!}
</div>

<div class="formulario-label-fiel">
  {!! Form::label('direccion', 'Dirección', array('class' => 'formulario-label ')) !!}
  {!! Form::text('direccion', null ,['class' => 'formulario-field']) !!}
</div>





<div class="formulario-label-fiel">
  {!! Form::label('codigo_pais_whatsapp', 'Código de celular del país', array('class' => 'formulario-label ')) !!}
  {!! Form::text('codigo_pais_whatsapp', null ,['class' => 'formulario-field']) !!}
</div>

<div class="formulario-label-fiel">
  {!! Form::label('mensaje_aviso_especial', 'Aviso Especial', array('class' => 'formulario-label ')) !!}
  <div class="modal-mensaje-aclarador">
    Aquí iría un mensaje de caracter muy especial para que le aparezca cuando inicia.
  </div>
  {!! Form::text('mensaje_aviso_especial', null ,['class' => 'formulario-field']) !!}
</div>





<div class="formulario-label-fiel">
  {!! Form::label('estado', 'Estado', array('class' => 'formulario-label ')) !!}
  {!! Form::select('estado',['si' => 'Si',
                             'no' => 'No'] , null,['class' => 'formulario-field'] )          !!}
</div>
