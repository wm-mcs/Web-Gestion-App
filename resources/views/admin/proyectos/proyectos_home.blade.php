@extends('layouts.admin_layout.admin_layout')

@section('content')

<div class="admin-contnedor-navegacion-miga">
  {{-- home --}}
  <a href="{{route('get_admin_home')}}"><span class="icon-home"></span></a>

  {{-- separador --}}
  <span class="spam-separador">|</span> 

  {{-- lugar donde esta --}}
  <span>Proyectos</span>
</div>

<div class="contenedor-admin-entidad">

 {{-- titulo --}}
 <div class="contenedor-admin-entidad-titulo-form-busqueda">
    <div class="admin-entidad-titulo">Proyectos 
     <a href="{{route('get_admin_proyectos_crear')}}">
      <span class="admin-user-boton-Crear">Crear 
       <span class="icon-add_circle_outline"></span> 
      </span>
     </a>  
    </div>
    @include('admin.proyectos.partes.buscador')
 </div>
 <div class="admin-contiene-entidades-y-pagination">
   <div class="admin-entidad-contenedor-entidades">
     @foreach($proyectos as $proyecto)
          @include('admin.proyectos.partes.lista')
     @endforeach
   </div>
   <div>
     {!! $proyectos->appends(Request::all())->render() !!}
   </div>
 </div>

 


  
</div>
  
@stop