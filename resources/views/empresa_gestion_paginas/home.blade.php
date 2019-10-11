@extends('layouts.gestion_socios_layout.admin_layout')


@section('miga-de-pan') 
  <span>Panel general de {{$Empresa->name}}</span>
@stop

@section('sucursal')
  
  <div class="contiene-sucursal">
    <span class="sucursal-estas">Estás en la sucursale</span> 
    <span class="sucursal-nombre">@{{Sucursal.name}} <i class="fas fa-hand-point-down"></i></span> 
  </div>
@stop

@section('content')
  

    
  
  {{-- Buscar Socio --}}
  <div class="empresa-gestion-barra-top-boton-y-forma-busqueda">

      <div class="empresa-gestion-contiene-input-busqueda">
        <input class="empresa-gestion-input-busqueda form-control" v-model="busqueda" type="text" placeholder="Buscar socio" aria-label="Search">
      </div>
      

      <socios-crear-boton accion_name="Crear"  :empresa="empresa" > </socios-crear-boton>
      <tipo-de-servicios-modal :servicios="servicios" :empresa="empresa"></tipo-de-servicios-modal>  
   
  </div>  

  
  <socio-entidad-listado :palabra_busqueda="busqueda"  :empresa="empresa"></socio-entidad-listado>












@stop

@section('vue-logica')


<script type="text/javascript">


     @include('empresa_gestion_paginas.Vue_logica.Componentes.tipo-de-servicios-modal-componente')
     @include('empresa_gestion_paginas.Vue_logica.Componentes.socios-crear-boton_componente')
     
      @include('empresa_gestion_paginas.Vue_logica.Componentes.socio-panel.estado-de-cuenta-saldo')
   
     @include('empresa_gestion_paginas.Vue_logica.Componentes.socio-entidad-listado-individual-componente')
     @include('empresa_gestion_paginas.Vue_logica.Componentes.socio-entidad-listado-componente')

     
     @include('empresa_gestion_paginas.Vue_logica.instancia_vue')



</script>

@stop


@section('columna')

  
  @include('admin.empresas_gestion_socios.columna_derecha.columna_logo_easy_socios')
  {{-- imagen logo --}}
  <a href="{{route('get_home')}}"><img class="admin-header-logo" src="{{$Empresa->url_img}}"></a>

  @include('admin.empresas_gestion_socios.columna_derecha.columna_operario')
  @include('admin.empresas_gestion_socios.columna_derecha.columna_dueño_empresa')
  @include('admin.empresas_gestion_socios.columna_derecha.columna_vendedor')
  @include('admin.empresas_gestion_socios.columna_derecha.columna_super_admin')
@stop