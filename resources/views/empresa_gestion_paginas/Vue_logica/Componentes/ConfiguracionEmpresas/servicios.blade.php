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
    <h1 class="col-12 col-lg-8" >Servicios</h1>
    <div class="col-12 col-lg-4">
      <crear-servicios></crear-servicios>
    </div>
    <p class="col-12 my-3 text-center">
     Son los tipo de planes "servicios" que vendés. Ejemplo: pase libre, cuponera de 8 clases, etc.
    </p>

  </div>


  <listado-servicios></listado-servicios>


  <p>

  </p>



@stop

@section('vue-logica')


<script type="text/javascript">

    @include('empresa_gestion_paginas.Vue_logica.Componentes.Helpers.onKeyPressMixIn')
    @include('empresa_gestion_paginas.Vue_logica.Componentes.ConfiguracionEmpresas.Componentes.Mixin.actividadesMixIn')
    @include('empresa_gestion_paginas.Vue_logica.Componentes.ConfiguracionEmpresas.Componentes.Servicios.crear')
    @include('empresa_gestion_paginas.Vue_logica.Componentes.ConfiguracionEmpresas.Componentes.Servicios.listado')
    @include('empresa_gestion_paginas.Vue_logica.Componentes.sucursa-nav')
    @include('empresa_gestion_paginas.Vue_logica.Componentes.Layout.atencion-al-cliente')
    @include('empresa_gestion_paginas.Vue_logica.instancia_vue')
</script>

@stop


@section('columna')


  @include('admin.empresas_gestion_socios.columna_derecha.columna_logo_easy_socios')

@stop
