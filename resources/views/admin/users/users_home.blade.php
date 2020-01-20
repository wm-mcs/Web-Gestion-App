@extends('layouts.gestion_socios_layout.admin_layout')


@section('miga-de-pan') 
  <span>Usuarios</span>
@stop



@section('content')






 {{-- titulo --}}
 <div class="contenedor-admin-entidad-titulo-form-busqueda">
    <div class="admin-entidad-titulo">Usuarios 
     <a href="{{route('get_admin_users_crear')}}">
      <span class="admin-user-boton-Crear">Crear 
       <span class="icon-add_circle_outline"></span> 
      </span>
     </a>  
    </div>
    @include('admin.users.partes.buscador')
 </div>
 <div class="admin-contiene-entidades-y-pagination">
   <div class="admin-entidad-contenedor-entidades">
     @foreach($users as $user)
          @include('admin.users.partes.lista')
     @endforeach
   </div>
   <div>
     {!! $users->appends(Request::all())->render() !!}
   </div>
 </div>

 


  

  
@stop


@section('columna')

 @include('admin.empresas_gestion_socios.columna_derecha.columna_logo_easy_socios')

  @include('admin.empresas_gestion_socios.columna_derecha.columna_operario')
  @include('admin.empresas_gestion_socios.columna_derecha.columna_dueño_empresa')
  @include('admin.empresas_gestion_socios.columna_derecha.columna_vendedor')
  @include('admin.empresas_gestion_socios.columna_derecha.columna_super_admin')
@stop


@section('vue-logica')


<script type="text/javascript">

   
@include('empresa_gestion_paginas.Vue_logica.instancia_users_vue')   



</script>

@stop