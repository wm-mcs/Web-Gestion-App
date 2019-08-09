@extends('layouts.admin_layout.admin_layout')

@section('content')

<div class="admin-contnedor-navegacion-miga">
  {{-- home --}}
  <a href="{{route('get_admin_home')}}"><span class="icon-home"></span></a>

  {{-- separador --}}
  <span class="spam-separador">|</span> 

  {{-- lugar atras --}}
  <a href="{{route('get_admin_proyectos')}}"><span>Proyectos</span></a>

  {{-- separador --}}
  <span class="spam-separador">|</span> 

  {{-- lugar donde esta --}}
  <span>Crear Proyecto</span>
</div>

<div class="contenedor-admin-entidad">

 {{-- titulo --}}
 <div class="admin-entidad-titulo">Crear Proyecto 
 </div>

 {{-- formulario --}}
  {!! Form::open(['route' => 'set_admin_proyectos_crear',
                            'method'=> 'post',
                            'files' =>  true,
                            'id'    => 'form-admin-empresa-datos'
                          ])               !!}
   <div class="formulario-contenedor">

   {{-- datos imagenes --}}
      <div class="contenedor-grupo-datos">
        <div class="contenedor-grupo-datos-titulo"><span class="icon-person"></span> Imagenes</div>
        <div class="contenedor-formulario-label-fiel">                       
          @include('admin.proyectos.formularios_partes.datos_imagenes')
        </div>
      </div>

      {{-- datos corporativos --}}
      <div class="contenedor-grupo-datos">
        <div class="contenedor-grupo-datos-titulo"><span class="icon-person"></span> Identidad</div>
        <div class="contenedor-formulario-label-fiel">                       
          @include('admin.proyectos.formularios_partes.datos_basicos')
        </div>
      </div>

     

      

      
   </div>
   <div class="admin-boton-editar">
     Crear Proyecto
   </div> 


  {!! Form::close() !!}


  
</div>
  
@stop