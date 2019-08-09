@extends('layouts.admin_layout.admin_layout')

@section('miga-de-pan') 

  <span>Empresas Gestion</span>
@stop

@section('content')



 {{-- titulo --}}
 <div class="contenedor-admin-entidad-titulo-form-busqueda">
    <div class="admin-entidad-titulo"> 
     <a href="{{route('get_admin_empresas_gestion_socios_crear')}}">
      <span class="admin-user-boton-Crear">Crear </span>
     </a>  
    </div>
    @include('admin.empresas_gestion_socios.partes.buscador')
 </div>
 <div class="admin-contiene-entidades-y-pagination">
   <div class="admin-entidad-contenedor-entidades">
     @foreach($Empresas as $marca)
          @include('admin.empresas_gestion_socios.partes.lista')
     @endforeach
   </div>
   <div>
     {!! $Empresas->appends(Request::all())->render() !!}
   </div>
 </div>

 


  

  
@stop