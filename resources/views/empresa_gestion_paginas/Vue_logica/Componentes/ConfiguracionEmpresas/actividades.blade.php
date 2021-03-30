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

                 <span>
                    > <a href="{{route('get_pagina_de_configuracion',['empresa_id' => $Empresa->id ])}}"> Configuración </a>
                 </span>


  {!! Form::close() !!}



@stop

@section('sucursal')
<sucursal-nav :empresa="empresa" :sucursal="Sucursal"></sucursal-nav>
@stop

@section('empresa-configuracion')

@stop

@section('content')




  <div class="row mx-0">
    <h1 class="col-12 col-lg-8" >Actividades</h1>
    <div class="col-12 col-lg-4">
      <crear-actividad></crear-actividad>
    </div>
    <p class="col-12 my-3 text-center">
      Aquí es donde crearás las clases o actividades. Por ejemplo: musculación, boxeo, aeróbica, karate, kik boxin, etc. Se usarán para la función de ingreso.
    </p>
    <p v-if="$root.empresa.sucursuales_empresa.length > 1 " class="col-12 my-3 text-center">
      Actividades de la sucursal <strong>@{{$root.Sucursal.name}}</strong>
    </p>
  </div>


  <listado-actividad></listado-actividad>


  <p>

  </p>



@stop

@section('vue-logica')




<script type="text/javascript">

    @include('empresa_gestion_paginas.Vue_logica.Componentes.Helpers.onKeyPressMixIn')
    @include('empresa_gestion_paginas.Vue_logica.Componentes.ConfiguracionEmpresas.Componentes.Actividad.listado')
    @include('empresa_gestion_paginas.Vue_logica.Componentes.ConfiguracionEmpresas.Componentes.Actividad.crear')
    @include('empresa_gestion_paginas.Vue_logica.Componentes.sucursa-nav')
    @include('empresa_gestion_paginas.Vue_logica.Componentes.Layout.atencion-al-cliente')
    @include('empresa_gestion_paginas.Vue_logica.instancia_vue')
</script>

@stop


@section('columna')


  @include('admin.empresas_gestion_socios.columna_derecha.columna_logo_easy_socios')

@stop
