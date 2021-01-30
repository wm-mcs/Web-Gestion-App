@extends('layouts.gestion_socios_layout.admin_layout')


@section('miga-de-pan')

@stop

@section('content')

<div class="row mx-0 align-items-center">


<div class="col-12 col-lg-6">
  <h1 class="h3 mb-0"> Planes </h1>
</div>

<div class="col-12 col-lg-6">
 <crear-plan></crear-plan>
</div>

</div>


<listado-de-planes></listado-de-planes>





@stop

@section('vue-logica')


<script type="text/javascript">
@include('empresa_gestion_paginas.Administrador.Vue.Bus.BusDeEventos')
@include('empresa_gestion_paginas.Administrador.Vue.Planes.crear_plan')
@include('empresa_gestion_paginas.Administrador.Vue.Planes.listado_de_planes')
@include('empresa_gestion_paginas.Vue_logica.instancia_users_vue')


</script>

@stop


@section('columna')


  @include('admin.empresas_gestion_socios.columna_derecha.columna_logo_easy_socios')
  @include('admin.empresas_gestion_socios.columna_derecha.columna_super_admin')


@stop
