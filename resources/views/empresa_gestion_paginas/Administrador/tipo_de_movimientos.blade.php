@extends('layouts.gestion_socios_layout.admin_layout')


@section('miga-de-pan') 
 
@stop

@section('content')



<crear-tipo-de-movimientos></crear-tipo-de-movimientos>
<tipo-de-movimientos></tipo-de-movimientos>


@stop

@section('vue-logica')


<script type="text/javascript">

@include('empresa_gestion_paginas.Administrador.Vue.crear_tipo_de_movimiento')
@include('empresa_gestion_paginas.Administrador.Vue.tipo-de-movimientos')
@include('empresa_gestion_paginas.Vue_logica.instancia_users_vue')

</script>

@stop


@section('columna')

  
  @include('admin.empresas_gestion_socios.columna_derecha.columna_logo_easy_socios')
  @include('admin.empresas_gestion_socios.columna_derecha.columna_super_admin')

  
@stop