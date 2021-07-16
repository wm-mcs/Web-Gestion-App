@extends('layouts.gestion_socios_layout.layout_gestion_socio_view_limpia')


@section('title')
 Control de acceso de {{$Empresa->name}}
@stop



@section('content')










     <control-acceso></control-acceso>















@stop

@section('vue-logica')
<script type="text/javascript">
     @include('empresa_gestion_paginas.Vue_logica.Componentes.ControlAcceso.control-acceso')
     @include('empresa_gestion_paginas.Vue_logica.instancia_vue')
</script>

@stop
