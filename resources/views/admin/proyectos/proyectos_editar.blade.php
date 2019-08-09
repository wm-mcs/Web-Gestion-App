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
  <span>Editar Proyecto: {{$proyecto->name}}</span>
</div>

<div class="contenedor-admin-entidad">

 <div class="contenedor-img-titulo">
   <img class="admin-entidad-img" src="{{$proyecto->url_img}}">
   {{-- titulo --}}
   <div class="admin-entidad-titulo">Editar Proyecto {{$proyecto->name}}</div>
 </div>
 
   @include('admin.proyectos.partes.parte_imagenes_adicionales')
 

 </div>
 

 {{-- formulario --}}
  {!! Form::model($proyecto,   ['route' => ['set_admin_proyectos_editar',$proyecto->id],
                            'method'=> 'patch',
                            'files' =>  true,
                            'id'    => 'form-admin-empresa-datos'
                          ])               !!}
   <div class="formulario-contenedor">

      {{-- datos corporativos --}}
      <div class="contenedor-grupo-datos">
        <div class="contenedor-grupo-datos-titulo"><span class="icon-person"></span> Datos</div>
        <div class="contenedor-formulario-label-fiel">                       
         @include('admin.proyectos.formularios_partes.datos_basicos')

         <div class="formulario-label-fiel">
            {!! Form::label('estado', 'Estado', array('class' => 'formulario-label ')) !!}
            {!! Form::select('estado',['si' => 'Activo',
                                       'no' => 'Desactivar'] , null )          !!}
         </div>
        </div>
      </div>

      

      

      
   </div>
   <div class="admin-boton-editar">
     Editar Proyecto
   </div> 


  {!! Form::close() !!}


  
</div>
  
@stop