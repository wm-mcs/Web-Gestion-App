<div class="formulario-label-fiel">
  {!! Form::label('factura_con_iva', '¿Factura con IVA?', array('class' => 'formulario-label ')) !!}
  {!! Form::select('factura_con_iva',['si' => 'Si',
                             'no' => 'No'] , null ,['class' => 'formulario-field'] )          !!}
</div>

<div class="formulario-label-fiel">
  {!! Form::label('razon_social', 'Razon social', array('class' => 'formulario-label ')) !!}
  {!! Form::text('razon_social', null ,['class' => 'formulario-field']) !!}
</div>

<div class="formulario-label-fiel">
  {!! Form::label('rut', 'Rut', array('class' => 'formulario-label ')) !!}
  {!! Form::text('rut', null ,['class' => 'formulario-field']) !!}
</div>
