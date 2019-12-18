@extends('layouts.gestion_socios_layout.admin_layout')


@section('miga-de-pan') 
  {!! Form::open(['route' => ['get_empresa_panel_de_gestion'],
                            'method'=> 'Post',
                            'files' =>  true,
                            'name'  => 'form1'
                          ])               !!}   
                 <input type="hidden" name="empresa_id" value="{{$Empresa->id}}">                 
                 <span class="simula_link empresa-lista-user-sucursal-nombre disparar-este-form" >
                  <img class="miga-imagen" src="{{$Empresa->url_img}}">
                 </span>    
 
  {!! Form::close() !!} 
  <span class="spam-separador"><i class="fas fa-chevron-right"></i></span>

  <span> Panel general de {{$Empresa->name}}</span>
@stop

@section('sucursal')  
  <sucursal-nav :empresa="empresa" :sucursal="Sucursal"></sucursal-nav>
@stop

@section('empresa-configuracion')  
<renovacion-automatica-empresa :empresa="empresa"></renovacion-automatica-empresa>
<configuracion-empresa :empresa="empresa"> </configuracion-empresa> 
@stop

@section('content')
  

  <avisos-empresa :empresa="empresa"></avisos-empresa>
  
  {{-- Buscar Socio --}}
  <div class="empresa-gestion-barra-top-boton-y-forma-busqueda">

      <div class="empresa-gestion-contiene-input-busqueda">
        <input class="empresa-gestion-input-busqueda form-control" v-model="busqueda" type="text" placeholder="Buscar socio" aria-label="Search">
      </div>
      

      <socios-crear-boton :accion_name="'Crear'"  :empresa="empresa" > </socios-crear-boton>
      <ingresar-movimiento-caja :empresa="empresa" :sucursal="Sucursal"></ingresar-movimiento-caja>
      <tipo-de-servicios-modal :servicios="servicios" :empresa="empresa"></tipo-de-servicios-modal>  
   
  </div>  

  
  <socio-entidad-listado :palabra_busqueda="busqueda"  :empresa="empresa"></socio-entidad-listado>












@stop

@section('vue-logica')


<script type="text/javascript">

     @include('empresa_gestion_paginas.Vue_logica.Componentes.Layout.avisos-empresa')
     @include('empresa_gestion_paginas.Vue_logica.Componentes.Layout.atencion-al-cliente')

     @include('empresa_gestion_paginas.Vue_logica.Componentes.Admin.tipo-de-servicios-empresa')
     @include('empresa_gestion_paginas.Vue_logica.Componentes.Layout.renovacion-automatica-empresa')
     @include('empresa_gestion_paginas.Vue_logica.Componentes.Layout.configuracion-empresa')
     @include('empresa_gestion_paginas.Vue_logica.Componentes.ingresar_movimiento_caja')
     @include('empresa_gestion_paginas.Vue_logica.Componentes.Layout.caja_lista')
     @include('empresa_gestion_paginas.Vue_logica.Componentes.Layout.caja_saldo')
     @include('empresa_gestion_paginas.Vue_logica.Componentes.sucursa-nav')
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
  

  @include('admin.empresas_gestion_socios.columna_derecha.columna_operario')
  @include('admin.empresas_gestion_socios.columna_derecha.columna_dueño_empresa')
  @include('admin.empresas_gestion_socios.columna_derecha.columna_vendedor')
  @include('admin.empresas_gestion_socios.columna_derecha.columna_super_admin')

  <caja-saldo></caja-saldo>
  <atencion-al-cliente :empresa="empresa"></atencion-al-cliente>
@stop