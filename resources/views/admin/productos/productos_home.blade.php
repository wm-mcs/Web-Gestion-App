@extends('layouts.admin_layout.admin_layout')


@section('miga-de-pan') 
  <span>Productos</span>
@stop

@section('content')





 {{-- titulo --}}
 <div class="contenedor-admin-entidad-titulo-form-busqueda">
    <div class="admin-entidad-titulo">Productos 
     <a href="{{route('get_admin_productos_crear')}}">
      <span class="admin-user-boton-Crear">Crear 
       <span class="icon-add_circle_outline"></span> 
      </span>
     </a>  
    </div>
    {{-- @include('admin.productos.partes.buscador') --}}
 </div>
 <div class="admin-contiene-entidades-y-pagination">
   <div class="admin-entidad-contenedor-entidades">
     @foreach($Entidades as $Entidad)
          @include('admin.productos.partes.lista')
     @endforeach
   </div>
   <div>
     {!! $Entidades->appends(Request::all())->render() !!}
   </div>
 </div>

 


  

  
@stop