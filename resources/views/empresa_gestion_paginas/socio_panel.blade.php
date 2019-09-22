@extends('layouts.gestion_socios_layout.admin_layout')


@section('miga-de-pan') 
  <span>Panel de socio {{$Socio->name}}</span>
@stop

@section('content')
  

    
  

<socio-panel-componente  :empresa="empresa"></socio-panel-componente>

   


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



@section('columna')

  {{-- imagen logo --}}
  <a href="{{route('get_home')}}"><img class="admin-header-logo" src="{{$Empresa->url_img}}"></a>

  @include('admin.empresas_gestion_socios.columna_derecha.columna_operario')
  @include('admin.empresas_gestion_socios.columna_derecha.columna_dueño_empresa')
  @include('admin.empresas_gestion_socios.columna_derecha.columna_vendedor')
  @include('admin.empresas_gestion_socios.columna_derecha.columna_super_admin')
@stop