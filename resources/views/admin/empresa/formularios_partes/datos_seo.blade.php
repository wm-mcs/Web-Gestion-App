<div class="formulario-label-fiel">
  {!! Form::label('palabras_claves', 'Palabras claves', array('class' => 'formulario-label ')) !!}
  {!! Form::text('palabras_claves', null ,['class' => 'formulario-field'

                                                                        ]) !!}
</div>

<div class="formulario-label-fiel">
  {!! Form::label('descripcion_breve', 'Descripción para seo', array('class' => 'formulario-label ')) !!}
  {!! Form::textarea('descripcion_breve', null ,['class' => 'formulario-field']) !!}
</div>