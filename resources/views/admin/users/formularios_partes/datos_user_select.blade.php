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



<div class="formulario-label-fiel">
{!! Form::label('img', 'Foto de perfil', array('class' => 'formulario-label ')) !!}
{!! Form::file('img',['class' => 'formulario-field']) !!}   
</div>





@if(isset($user))
<div class="admin-img-section-contenedor" >
  <div class="admin-img-section-text">Foto de perfil</div>
  <div class="modal-mensaje-aclarador">
                Imagen de formato <strong>cuadrado</strong> ejemplo 200px x 200px.


  </div>
  <img class="admin-img-section-img" src="{{$user->foto_de_perfil}}"> 
</div>
@endif





