@extends('layouts.gestion_socios_layout.admin_layout')


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
      <empresa-lista v-for="Empresa in  {!! json_encode($Empresas) !!}" :empresa="Empresa"> </empresa-lista>
   </div>
   <div>
    
   </div>
 </div>

 


  

  
@stop

@section('vue-logica')


<script type="text/javascript">


    

@include('empresa_gestion_paginas.Vue_logica.Componentes.Admin.empresa_lista')        
@include('empresa_gestion_paginas.Vue_logica.instancia_vue')   



</script>

@stop



@section('columna')

 @include('admin.empresas_gestion_socios.columna_derecha.columna_logo_easy_socios')

  @include('admin.empresas_gestion_socios.columna_derecha.columna_operario')
  @include('admin.empresas_gestion_socios.columna_derecha.columna_dueño_empresa')
  @include('admin.empresas_gestion_socios.columna_derecha.columna_vendedor')
  @include('admin.empresas_gestion_socios.columna_derecha.columna_super_admin')
@stop