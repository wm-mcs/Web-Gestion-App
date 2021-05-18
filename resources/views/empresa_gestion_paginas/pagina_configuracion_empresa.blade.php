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

@stop

@section('content')




  <div class="row mx-0 justify-content-center">
    <h1 class="col-12 h4 text-center" >Configuración de la empresa</h1>
    <div class="col-12 col-lg-4">
    </div>
    <p class="col-12 mb-5 text-center">
      <small>
        Estos botones de aquí abajo te permitiran configurar todo EasySocio.
      </small>
    </p>
  </div>

  <div class="row mx-0 p-3 shadow  w-100 mb-5">
    <div class="col-12 mb-2">
       <b>¿Qué servicios se venden?</b>
    </div>
    <div class="col-12 col-lg-4 mb-4">
        <div class="formulario-label-aclaracion text-center mb-1">
            Son los servicios que vendés. Ejemplo: pase libre, cuponera de 8 clases, etc.
        </div>
        <a class="Boton-Fuente-Chica Boton-Primario-Relleno" href="{{route('get_servicios_index',['empresa_id' => $Empresa->id ])}}">
            Servicios
        </a>
    </div>
  </div>

  @if($Empresa->reserva_online_habilitado)
  <div class="row mx-0 p-3 shadow w-100 mb-5">
    <div class="col-12 mb-2">
        <b>Configurar sistema de reservas online</b>
    </div>

    <div class="col-12 col-lg-4 mb-4">
      <div class="formulario-label-aclaracion text-center mb-1">
          Las actividades son el tipo de clases o "actividades" que se brindan. Por ejemplo "musculación",'karate', "boxeo", "funcional".
      </div>
      <a class="Boton-Fuente-Chica Boton-Primario-Relleno" href="{{route('get_actividades_index',['empresa_id' => $Empresa->id ])}}">
          Actividades
      </a>
    </div>

    <div class="col-12 col-lg-4 mb-4">
        <div class="formulario-label-aclaracion text-center mb-1">
            Aquí se define el calendario (cronograma) de actividades. Esto se usará para la función de reserva de clases online.
        </div>
        <a class="Boton-Fuente-Chica Boton-Primario-Relleno" href="{{route('get_index_agenda',['empresa_id' => $Empresa->id ])}}">
            Calendario
        </a>
    </div>
  </div>
  @endif

  @if($Empresa->grupos_habilitado)

  <div class="row mx-0 p-3 shadow w-100 mb-5">
    <div class="col-12 mb-2">
        <b>¿Tenés grupos definidos?</b>
    </div>

    <div class="col-12 col-lg-4 mb-4">
      <div class="formulario-label-aclaracion text-center mb-1">
         Organizá tu academia creando grupos. Podrás vincular socios por medio de estos grupos.
      </div>
      <a class="Boton-Fuente-Chica Boton-Primario-Relleno" href="{{route('get_grupos_index',['empresa_id' => $Empresa->id ])}}">
          Grupos
      </a>
    </div>


  </div>
  @endif







@stop

@section('vue-logica')


<script type="text/javascript">
    @include('empresa_gestion_paginas.Vue_logica.Componentes.sucursa-nav')
    @include('empresa_gestion_paginas.Vue_logica.Componentes.Layout.atencion-al-cliente')
    @include('empresa_gestion_paginas.Vue_logica.instancia_vue')
</script>

@stop


@section('columna')

  @include('admin.empresas_gestion_socios.columna_derecha.columna_logo_easy_socios')

@stop
