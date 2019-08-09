@extends('layouts.admin_layout.admin_layout')

@section('content')

<div class="admin-contnedor-navegacion-miga">
  {{-- home --}}
  <a href="{{route('get_admin_home')}}"><span class="icon-home"></span></a>

  {{-- separador --}}
  <span class="spam-separador"><span class="icon-keyboard_arrow_right"></span></span> 

  {{-- lugar atras --}}
  <a href="{{route('get_admin_modelos')}}"><span>Modelos</span></a>

  {{-- separador --}}
  <span class="spam-separador"><span class="icon-keyboard_arrow_right"></span></span> 

  {{-- lugar donde esta --}}
  <span>Editar Modelo: {{$modelo->name}}</span>
</div>

<div class="contenedor-admin-entidad">

 {{-- titulo --}}
 <div class="admin-entidad-titulo">Editar Modelo {{$modelo->name}}
 </div>

 {{-- formulario --}}
  {!! Form::model($modelo,   ['route' => ['set_admin_marcas_editar',$modelo->id],
                            'method'=> 'patch',
                            'files' =>  true,
                            'id'    => 'form-admin-empresa-datos'
                          ])               !!}
   <div class="formulario-contenedor">

      {{-- datos corporativos --}}
      <div class="contenedor-grupo-datos">
        <div class="contenedor-grupo-datos-titulo"><span class="icon-person"></span> Identidad</div>
        <div class="contenedor-formulario-label-fiel">                       
         @include('admin.modelos.formularios_partes.datos_basicos')
        </div>
      </div>

      {{-- imagenes corporativos --}}
      <div class="contenedor-grupo-datos">
        <div class="contenedor-grupo-datos-titulo"><span class="icon-person"></span> Estado y Rol</div>
        <div class="contenedor-formulario-label-fiel">                       
          @include('admin.modelos.formularios_partes.datos_imagenes')
        </div>
      </div>

      

      
   </div>
   <div class="admin-boton-editar">
     Editar Modelo
   </div> 


  {!! Form::close() !!}


  
</div>
  
@stop