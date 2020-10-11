@extends('layouts.gestion_socios_layout.layout_gestion_socio_view_limpia')


@section('title') 
 Control de acceso de {{$Empresa->name}}
@stop



@section('content')
  


<div class="controll-access-contenedor d-flex flex-row align-items-center justify-content-center ">
     
     <img class="controll-access-easy-socio-logo" src="/imagenes/Empresa/logo_rectangular.png" alt="EasySocio">
     
     <div class="w-100 d-flex flex-column align-items-center">
          
          @if(file_exists($Empresa->path_url_img)) 
           <img class="my-3 controll-access-empresa-cliente-logo" src="{{$Empresa->url_img}}">
          @endif
          
          <h1 class="sub-titulos-class text-center">Control de acceso</h1>

          

     </div>



</div>










@stop

@section('vue-logica')
<script type="text/javascript"> 
     @include('empresa_gestion_paginas.Vue_logica.instancia_vue')
</script>

@stop

