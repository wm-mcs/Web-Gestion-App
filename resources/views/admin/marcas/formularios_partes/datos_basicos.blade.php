<div class="formulario-label-fiel">
  {!! Form::label('name', 'Nombre', array('class' => 'formulario-label ')) !!}
  {!! Form::text('name', null ,['class' => 'formulario-field']) !!}
</div>

<div class="formulario-label-fiel">
  {!! Form::label('description', 'Descripción', array('class' => 'formulario-label ')) !!}
  {!! Form::textarea('description', null ,['class' => 'formulario-field']) !!}
</div>

<div class="formulario-label-fiel">
  {!! Form::label('rank', 'Calidad / Prestigio', array('class' => 'formulario-label ')) !!}
  {!! Form::select('rank',  [1 => '1 - Normal',
                             2 => '2 - Alta ',
                             3 => '3 - Elite'] , null )          !!}
</div>
<div class="formulario-label-fiel">
  {!! Form::label('estado', 'Estado', array('class' => 'formulario-label ')) !!}
  {!! Form::select('estado',['si' => 'Activo',
                             'no' => 'Inactivo'] , null )          !!}
</div>

