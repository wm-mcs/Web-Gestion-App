@extends('layouts.gestion_socios_layout.admin_layout')


@section('miga-de-pan') 


  <span> Panel administrador de general de {{$Empresa->name}}</span>
@stop

@section('sucursal')  
  <sucursal-nav :empresa="empresa" :sucursal="Sucursal"></sucursal-nav>
@stop

@section('content')
  

    
  
  {{-- Buscar Socio --}}
  <div class="empresa-gestion-barra-top-boton-y-forma-busqueda">

     
      

     
   
  </div>  

  
  












@stop

@section('vue-logica')


<script type="text/javascript">
     

     
     @include('empresa_gestion_paginas.Vue_logica.instancia_vue')



</script>

@stop


@section('columna')

  
  @include('admin.empresas_gestion_socios.columna_derecha.columna_logo_easy_socios')
  

  
  @include('admin.empresas_gestion_socios.columna_derecha.columna_vendedor')
  @include('admin.empresas_gestion_socios.columna_derecha.columna_super_admin')

 
@stop