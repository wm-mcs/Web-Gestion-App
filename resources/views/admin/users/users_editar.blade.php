@extends('layouts.admin_layout.admin_layout')


@section('miga-de-pan')
 

  {{-- lugar atras --}}
  <a href="{{route('get_admin_users')}}"><span>Usuarios</span></a>

  {{-- separador --}}
  <span class="spam-separador">|</span> 
  
  {{-- lugar donde esta --}}
  <span>Editar a {{$user->name}}</span>
@stop



@section('content')





 {{-- formulario --}}
  {!! Form::model($user,   ['route' => ['set_admin_users_editar',$user->id],
                            'method'=> 'patch',
                            'files' =>  true,
                            'id'    => 'form-admin-empresa-datos'
                          ])               !!}
   <div class="formulario-contenedor">

      {{-- datos corporativos --}}
      <div class="contenedor-grupo-datos">
        <div class="contenedor-grupo-datos-titulo"><span class="icon-person"></span> Identidad</div>
        <div class="contenedor-formulario-label-fiel">                       
          @include('admin.users.formularios_partes.datos_user')
        </div>
      </div>

      {{-- imagenes corporativos --}}
      <div class="contenedor-grupo-datos">
        <div class="contenedor-grupo-datos-titulo"><span class="icon-person"></span> Estado y Rol</div>
        <div class="contenedor-formulario-label-fiel">                       
          @include('admin.users.formularios_partes.datos_user_select')
        </div>
      </div>

      

      
   </div>
   <div class="admin-boton-editar">
     Editar Usuario
   </div> 


  {!! Form::close() !!}


  

  
@stop