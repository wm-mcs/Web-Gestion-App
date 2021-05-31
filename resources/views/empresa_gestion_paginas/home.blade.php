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


  <div class="row mx-0 align-items-center mb-5">
    <div class="col-12 col-lg-8 mb-2 mb-lg-0">
    <fieldset class="float-label mb-0">
                      <input
                        name="busqueda"
                        type="text"
                        class="input-text-class-primary"
                        v-model="busqueda"
                        aria-label="Search"

                        required

                      />
                      <label for="busqueda">Buscar socio</label>
                    </fieldset>

    </div>
    <div class="col-3 col-lg-1">
    <socios-crear-boton :accion_name="'Crear'"  :empresa="empresa" > </socios-crear-boton>
    </div>
    <div class="col-3 col-lg-1">
    <ingresar-movimiento-caja :empresa="empresa" :sucursal="Sucursal"></ingresar-movimiento-caja>
    </div>
    {!! Form::open(['route'  => 'get_analiticas',
                  'method' => 'Post',
                  'class'  => 'col-3 col-lg-1'])                         !!}
      <input type="hidden" name="empresa_id" value="{{$Empresa->id}}">
      <div class="admin-user-boton-Crear disparar-este-form">
        <i class="far fa-chart-bar"></i>
      </div>
     {!! Form::close() !!}
    <div class="col-3 col-lg-1">
      <a class="admin-user-boton-Crear"  href="{{route('get_pagina_de_configuracion',['empresa_id' => $Empresa->id ])}}"> <i class="fas fa-cog"></i></a>
    </div>
  </div>


  <socio-entidad-listado :palabra_busqueda="busqueda"  :empresa="empresa"></socio-entidad-listado>












@stop

@section('vue-logica')


<script type="text/javascript">

     @include('empresa_gestion_paginas.Vue_logica.Componentes.Layout.avisos-empresa')
     @include('empresa_gestion_paginas.Vue_logica.Componentes.Layout.atencion-al-cliente')


     @include('empresa_gestion_paginas.Vue_logica.Componentes.Layout..reservas-admin')
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
  @include('admin.empresas_gestion_socios.columna_derecha.columna_dueno')

  @if($Empresa->reserva_online_habilitado)
  <reservas-admin></reservas-admin>

  @endif


  <caja-saldo></caja-saldo>
  <atencion-al-cliente :empresa="empresa"></atencion-al-cliente>
@stop
