@extends('layouts.gestion_socios_layout.admin_layout')


@section('miga-de-pan') 
  {!! Form::open(['route' => ['get_empresa_panel_de_gestion'],
                            'method'=> 'Post',
                            'files' =>  true,
                            'name'  => 'form1'
                          ])               !!}   
                 <input type="hidden" name="empresa_id" value="{{$Empresa->id}}">                 
                 
                  @if(file_exists($Empresa->path_url_img))   
                  <span class="simula_link  disparar-este-form" >           
                  
                    <img class="miga-imagen" src="{{$Empresa->url_img}}">
                   </span> 
                    
                 @else
                   <span class="simula_link disparar-este-form">
                   {{$Empresa->name}}
                 </span> 
                 @endif
                    
 
  {!! Form::close() !!} 
  

 
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

  <control-de-acceso-movimientos ></control-de-acceso-movimientos>

@stop

@section('vue-logica')


<script type="text/javascript">


    
     @include('empresa_gestion_paginas.Vue_logica.Componentes.ControlAcceso.control-de-acceso-movimientos')
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
  @include('admin.empresas_gestion_socios.columna_derecha.columna_control_access')



  <caja-saldo></caja-saldo>
  <atencion-al-cliente :empresa="empresa"></atencion-al-cliente>
@stop