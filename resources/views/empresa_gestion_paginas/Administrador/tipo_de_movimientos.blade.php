@extends('layouts.gestion_socios_layout.admin_layout')


@section('miga-de-pan') 
 
@stop

@section('content')














@stop

@section('vue-logica')


<script type="text/javascript">



@include('empresa_gestion_paginas.Vue_logica.instancia_users_vue')

</script>

@stop


@section('columna')

  
  @include('admin.empresas_gestion_socios.columna_derecha.columna_logo_easy_socios')
  @include('admin.empresas_gestion_socios.columna_derecha.columna_super_admin')

  
@stop