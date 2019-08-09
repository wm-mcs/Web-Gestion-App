@extends('layouts.admin_layout.admin_layout')

@section('content')

<div class="admin-contnedor-navegacion-miga">
  {{-- home --}}
  <a href="{{route('get_admin_home')}}"><span class="icon-home"></span></a>

  {{-- separador --}}
  <span class="spam-separador"><span class="icon-keyboard_arrow_right"></span></span> 

  {{-- lugar donde esta --}}
  <span>Modelos</span>
</div>

<div class="contenedor-admin-entidad">

 {{-- titulo --}}
 <div class="contenedor-admin-entidad-titulo-form-busqueda">
    <div class="admin-entidad-titulo">Marcas 
     <a href="{{route('get_admin_modelos_crear')}}">
      <span class="admin-user-boton-Crear">Crear 
       <span class="icon-add_circle_outline"></span> 
      </span>
     </a>  
    </div>
    @include('admin.modelos.partes.buscador')
 </div>
 <div class="admin-contiene-entidades-y-pagination">
   <div class="admin-entidad-contenedor-entidades">
     @foreach($modelos as $modelo)
          @include('admin.modelos.partes.lista')
     @endforeach
   </div>
   <div>
     {!! $modelos->appends(Request::all())->render() !!}
   </div>
 </div>

 


  
</div>
  
@stop