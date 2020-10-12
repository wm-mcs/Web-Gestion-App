@extends('layouts.gestion_socios_layout.layout_gestion_socio_view_limpia')


@section('title') 
 Control de acceso de {{$Empresa->name}}
@stop



@section('content')
  


<div class="controll-access-contenedor d-flex flex-row align-items-center justify-content-center ">
     
 <div class="controll-access-easy-socio-logo-wraper d-flex flex-row align-items-center justify-content-center">
   <img class="controll-access-easy-socio-logo" src="/imagenes/Empresa/logo_rectangular.png" alt="EasySocio">
 </div>    
     
     


     <control-acceso></control-acceso>
     



</div>










@stop

@section('vue-logica')
<script type="text/javascript"> 
     @include('empresa_gestion_paginas.Vue_logica.Componentes.ControlAcceso.control-acceso')
     @include('empresa_gestion_paginas.Vue_logica.instancia_vue')
</script>

@stop

