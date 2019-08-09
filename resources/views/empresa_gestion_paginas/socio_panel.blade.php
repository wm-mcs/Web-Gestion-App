@extends('layouts.gestion_socios_layout.admin_layout')


@section('miga-de-pan') 
  <span>Panel de socio {{$Socio->name}}</span>
@stop

@section('content')
  

    
  

<socio-panel-componente :servicios="servicios"></socio-panel-componente>

   


@stop

@section('vue-logica')


<script type="text/javascript">


    
     @include('empresa_gestion_paginas.Vue_logica.Componentes.socio-panel.estado-de-cuenta-socio-componente') 
     @include('empresa_gestion_paginas.Vue_logica.Componentes.socio-panel.entidad-servicio-socio-componente')  
     @include('empresa_gestion_paginas.Vue_logica.Componentes.socio-panel.agregar-al-socio-un-servicio-componente')  
     @include('empresa_gestion_paginas.Vue_logica.Componentes.socio-panel-componente')  
     @include('empresa_gestion_paginas.Vue_logica.instancia_vue')



</script>

@stop