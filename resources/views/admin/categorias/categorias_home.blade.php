@extends('layouts.admin_layout.admin_layout')

@section('miga-de-pan') 

  <span>Categorias</span>
@stop

@section('content')



 {{-- titulo --}}
 <div class="contenedor-admin-entidad-titulo-form-busqueda">
    <div class="admin-entidad-titulo">Categorias 
     <a href="{{route('get_admin_categorias_crear')}}">
      <span class="admin-user-boton-Crear">Crear 
       <span class="icon-add_circle_outline"></span> 
      </span>
     </a>  
    </div>
    @include('admin.categorias.partes.buscador')
 </div>
 <div class="admin-contiene-entidades-y-pagination">
   <div class="admin-entidad-contenedor-entidades">
     @foreach($Categorias as $marca)
          @include('admin.categorias.partes.lista')
     @endforeach
   </div>
   <div>
     {!! $Categorias->appends(Request::all())->render() !!}
   </div>
 </div>

 


  

  
@stop