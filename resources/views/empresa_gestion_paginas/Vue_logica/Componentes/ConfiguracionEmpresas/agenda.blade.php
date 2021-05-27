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
    <h1 class="h3 col-12 col-lg-8 font-weight-bold" >Cronograma de actividades</h1>
    <div class="col-12 col-lg-4">
     <crear-agenda></crear-agenda>
    </div>
    <p class="col-12 my-5 text-center">
      <small>Aquí es donde crearás las actividades, asignando: día, hora y cupos (si es que los tuviera) de las clases que ofrece tu emprendimiento.
      Esto se usará para la funcionalidad de reserva de clases por internet.</small>

    </p>
    <p v-if="$root.empresa.sucursuales_empresa.length > 1 " class="col-12 my-3 text-center">
      Cronograma de la sucursal <strong>@{{$root.Sucursal.name}}</strong>
    </p>
  </div>

    <listado> </listado>
  <p>

  </p>



@stop

@section('vue-logica')


<script type="text/javascript">
    @include('empresa_gestion_paginas.Vue_logica.Componentes.ConfiguracionEmpresas.Componentes.Mixin.actividadesMixIn')
    @include('empresa_gestion_paginas.Vue_logica.Componentes.Helpers.erroresMixin')
    @include('empresa_gestion_paginas.Vue_logica.Componentes.Helpers.onKeyPressMixIn')
    @include('empresa_gestion_paginas.Vue_logica.Componentes.sucursa-nav')
    @include('empresa_gestion_paginas.Vue_logica.Componentes.ConfiguracionEmpresas.Componentes.Agenda.lista')
    @include('empresa_gestion_paginas.Vue_logica.Componentes.ConfiguracionEmpresas.Componentes.Agenda.listado')
    @include('empresa_gestion_paginas.Vue_logica.Componentes.ConfiguracionEmpresas.Componentes.Agenda.crear')
    @include('empresa_gestion_paginas.Vue_logica.Componentes.Layout.atencion-al-cliente')
    @include('empresa_gestion_paginas.Vue_logica.instancia_vue')
</script>

@stop


@section('columna')


  @include('admin.empresas_gestion_socios.columna_derecha.columna_logo_easy_socios')

@stop
