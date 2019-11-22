@extends('layouts.gestion_socios_layout.admin_layout')


@section('miga-de-pan') 
  
  {!! Form::open(['route' => ['get_empresa_panel_de_gestion'],
                            'method'=> 'Post',
                            'files' =>  true,
                            'name'  => 'form1',
                            'class' => 'flex-row-start'
                          ])               !!}   
                 <input type="hidden" name="empresa_id" value="{{$Empresa->id}}">                 
                 <span class="simula_link empresa-lista-user-sucursal-nombre disparar-este-form" >
                  <img class="miga-imagen" src="{{$Empresa->url_img}}">
                 </span> 
                 <span class="spam-separador"><i class="fas fa-chevron-right"></i></span>  
                 <span class="simula_link disparar-este-form">
                   {{$Empresa->name}}
                 </span> 
 
  {!! Form::close() !!} 

  <span class="spam-separador"><i class="fas fa-chevron-right"></i></span>
  <span>Panel de socio</span>
@stop

@section('sucursal')  
  <sucursal-nav :empresa="empresa" :sucursal="Sucursal"></sucursal-nav>
@stop
@section('empresa-configuracion')  

<renovacion-automatica-empresa :empresa="empresa"></renovacion-automatica-empresa>
<configuracion-empresa :empresa="empresa"> </configuracion-empresa> 
@stop
@section('content')
  

    
  

<socio-panel-componente  :empresa="empresa" :sucursal="Sucursal"></socio-panel-componente>

   


@stop

@section('vue-logica')


<script type="text/javascript">
     @include('empresa_gestion_paginas.Vue_logica.Componentes.Layout.renovacion-automatica-empresa')
     @include('empresa_gestion_paginas.Vue_logica.Componentes.Layout.configuracion-empresa')
     @include('empresa_gestion_paginas.Vue_logica.Componentes.socio-panel.servicio-renovacion-lista') 
     @include('empresa_gestion_paginas.Vue_logica.Componentes.sucursa-nav')
     @include('empresa_gestion_paginas.Vue_logica.Componentes.socio-panel.ingresar-movimiento-a-socio') 
     @include('empresa_gestion_paginas.Vue_logica.Componentes.Layout.caja_lista')
     @include('empresa_gestion_paginas.Vue_logica.Componentes.Layout.caja_saldo')
     @include('empresa_gestion_paginas.Vue_logica.Componentes.socio-panel.estado-de-cuenta-socio-componente') 
     @include('empresa_gestion_paginas.Vue_logica.Componentes.socio-panel.entidad-servicio-socio-componente')  
     @include('empresa_gestion_paginas.Vue_logica.Componentes.socio-panel.agregar-al-socio-un-servicio-componente') 
     @include('empresa_gestion_paginas.Vue_logica.Componentes.socio-panel.estado-de-cuenta-saldo')
     @include('empresa_gestion_paginas.Vue_logica.Componentes.socio-panel-componente')  
     @include('empresa_gestion_paginas.Vue_logica.instancia_vue')



</script>

@stop   



@section('columna')

  @include('admin.empresas_gestion_socios.columna_derecha.columna_logo_easy_socios')

  

  @include('admin.empresas_gestion_socios.columna_derecha.columna_operario')
  @include('admin.empresas_gestion_socios.columna_derecha.columna_dueño_empresa')
  @include('admin.empresas_gestion_socios.columna_derecha.columna_vendedor')
  

  <caja-saldo></caja-saldo>
@stop