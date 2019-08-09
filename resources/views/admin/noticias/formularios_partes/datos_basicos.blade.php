<div class="formulario-label-fiel">
  {!! Form::label('name', 'Título', array('class' => 'formulario-label ')) !!}
  {!! Form::text('name', null ,['class' => 'formulario-field']) !!}
</div>

<div class="formulario-label-fiel">
  {!! Form::label('sub_name', 'Sub título', array('class' => 'formulario-label ')) !!}
  {!! Form::text('sub_name', null ,['class' => 'formulario-field']) !!}
</div>



<div class="formulario-label-fiel">
  @include('admin.noticias.formularios_partes.aclaracion_etiquetas')
  {!! Form::label('description', 'Contenido', array('class' => 'formulario-label ')) !!}
  {!! Form::textarea('description', null ,['class' => 'formulario-field']) !!}
</div>

<div class="formulario-label-fiel">
  {!! Form::label('url_video', 'URL de Video', array('class' => 'formulario-label ')) !!}
  {!! Form::text('url_video', null ,['class' => 'formulario-field']) !!}
</div>

<div class="formulario-label-fiel">
  {!! Form::label('estado', 'Estado', array('class' => 'formulario-label ')) !!}
  {!! Form::select('estado',['si' => 'Activo',
                             'no' => 'Desactivar'] , null )          !!}
</div>

