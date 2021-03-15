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

@stop

@section('empresa-configuracion')

@stop

@section('content')


  <avisos-empresa :empresa="empresa"></avisos-empresa>

  <h1>Agenda</h1>



@stop

@section('vue-logica')


<script type="text/javascript">





     @include('empresa_gestion_paginas.Vue_logica.Componentes.Layout.atencion-al-cliente')



     @include('empresa_gestion_paginas.Vue_logica.instancia_vue')

</script>

@stop


@section('columna')


  @include('admin.empresas_gestion_socios.columna_derecha.columna_logo_easy_socios')

@stop
