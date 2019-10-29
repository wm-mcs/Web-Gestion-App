<div class="formulario-label-fiel">
  {!! Form::label('estado', 'Estado', array('class' => 'formulario-label ')) !!}
  {!! Form::select('estado',['si' => 'Activo',
                             'no' => 'Desactivar'] , null )          !!}
</div>

<div class="formulario-label-fiel">
  {!! Form::label('role', 'Role', array('class' => 'formulario-label ')) !!}
  @if(Auth::user()->role < 10)
     {!! Form::select('role', config('options.role_para_user'),null ) !!}
  @else
     {!! Form::select('role', config('options.role'),null ) !!}
  @endif 
</div>





