@extends('layouts.admin_layout.admin_layout')

@section('miga-de-pan') 

  <span>Marcas</span>
@stop

@section('content')



 {{-- titulo --}}
 <div class="contenedor-admin-entidad-titulo-form-busqueda">
    <div class="admin-entidad-titulo"> 
     <a href="{{route('get_admin_marcas_crear')}}">
      <span class="admin-user-boton-Crear">Crear 
       <span class="icon-add_circle_outline"></span> 
      </span>
     </a>  
    </div>
    @include('admin.marcas.partes.buscador')
 </div>
 <div class="admin-contiene-entidades-y-pagination">
   <div class="admin-entidad-contenedor-entidades">
     @foreach($marcas as $marca)
          @include('admin.marcas.partes.lista')
     @endforeach
   </div>
   <div>
     {!! $marcas->appends(Request::all())->render() !!}
   </div>
 </div>

 


  

  
@stop