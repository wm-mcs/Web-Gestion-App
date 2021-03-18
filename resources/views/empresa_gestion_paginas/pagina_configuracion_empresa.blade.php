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




  <div class="row mx-0">
    <h1 class="col-12 col-lg-8" >Configuración de la empresa</h1>
    <div class="col-12 col-lg-4">

    </div>
    <p class="col-12 my-3 text-center">
      Estos botones de aquí abajo te permitiran configurar todo EasySocio.
    </p>


    <div class="col-4 mb-4">
        <div class="formulario-label-aclaracion text-center mb-1">
            Las actividades son el tipo de clases o "actividades" que se brindan. Por ejemplo "musculación",'karate',"boxeo","funcional".
        </div>
        <a class="Boton-Fuente-Chica Boton-Primario-Relleno" href="{{route('get_actividades_index',['empresa_id' => $Empresa->id ])}}">
            Actividades
        </a>
    </div>

    <div class="col-4 mb-4">
        <div class="formulario-label-aclaracion text-center mb-1">
            Aquí se define los días, horas y cupos de las clases. Esto se usará para la función de reserva de clases online.
        </div>
        <a class="Boton-Fuente-Chica Boton-Primario-Relleno" href="{{route('get_index_agenda',['empresa_id' => $Empresa->id ])}}">
            Cronograma
        </a>
    </div>

  </div>


  <p>

  </p>



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
