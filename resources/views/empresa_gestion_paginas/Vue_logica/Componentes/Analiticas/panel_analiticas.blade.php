@extends('layouts.gestion_socios_layout.admin_layout')


@section('miga-de-pan')

@stop

@section('content')

<div class="row mx-0 align-items-center mb-4">
  <div class="col-12 col-lg-6">
    <h1 class="h3 mb-0"> Finanzas y analíticas </h1>
  </div>
  <div class="col-12 col-lg-6">

  </div>


</div>
<div class="row mx-0 align-items-center">

  <div class="col-12">
      <ventas-gastos-segun-periodo></ventas-gastos-segun-periodo>
  </div>

</div>










@stop

@section('vue-logica')

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
<script src="https://unpkg.com/vue-chartjs/dist/vue-chartjs.min.js"></script>

<script type="text/javascript">

  @include('empresa_gestion_paginas.Vue_logica.Componentes.Analiticas.ventas_gastos_segun_periodo')
  @include('empresa_gestion_paginas.Vue_logica.instancia_vue')


</script>

@stop


@section('columna')


  @include('admin.empresas_gestion_socios.columna_derecha.columna_logo_easy_socios')



@stop
