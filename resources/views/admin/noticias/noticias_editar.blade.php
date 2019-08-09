@extends('layouts.admin_layout.admin_layout')


@section('miga-de-pan')
 

  {{-- lugar atras --}}
  <a href="{{route('get_admin_noticias')}}"><span>Noticias</span></a>

  {{-- separador --}}
  <span class="spam-separador"> | </span> 

  {{-- lugar donde esta --}}
  <span><a href="{{$Entidad->route}}">{{$Entidad->name}}</a></span>
@stop

@section('content')



 {{-- formulario --}}
  {!! Form::model($Entidad,   ['route' => ['set_admin_noticias_editar',$Entidad->id],
                            'method'=> 'patch',
                            'files' =>  true,
                            'id'    => 'form-admin-empresa-datos'
                          ])               !!}
   <div class="formulario-contenedor">

      {{-- datos corporativos --}}
      <div class="contenedor-grupo-datos">
        <div class="contenedor-grupo-datos-titulo"><span class="icon-person"></span> Identidad</div>
        <div class="contenedor-formulario-label-fiel">                       
         @include('admin.noticias.formularios_partes.datos_basicos')
        </div>
      </div>

      {{-- imagenes corporativos --}}
      <div class="contenedor-grupo-datos">
        <div class="contenedor-grupo-datos-titulo"><span class="icon-person"></span> Estado </div>
        <div class="contenedor-formulario-label-fiel">                       
          @include('admin.noticias.formularios_partes.datos_imagenes')
        </div>
      </div>

      

      
   </div>
   <div class="admin-boton-editar">
     Editar Noticia
   </div> 

  {!! Form::close() !!}

@stop