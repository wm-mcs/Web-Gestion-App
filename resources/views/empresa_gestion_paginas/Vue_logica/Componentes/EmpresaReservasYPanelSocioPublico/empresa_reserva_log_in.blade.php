@extends('layouts.gestion_socios_layout.public_layout')






@section('content')


<div style="min-height: 100vh;" class="w-100 d-flex flex-row align-items-center justify-content-center">
        <div class="w-100 d-flex flex-column align-items-center">
          <div class="">
            @include('layouts.gestion_socios_layout.mensajes.mensajes')
          </div>

          <div class="container d-flex flex-row align-items-center justify-content-center">
            <div class="w-100 d-flex flex-column align-items-center p-2 py-lg-4 ">
                <div class="col-6 col-lg-4 p-2 p-lg-5 my-5 my-lg-3">
                    <img class="img-fluid " src="{{$Data['img']}}">
                </div>

                <div class="col-11 col-lg-5 background-gris-0 p-5 ">
                <h1 class="sub-titulos-class font-secondary text-color-black text-center mt-1 mb-3">Inicio de sesión</h1>
                @include('formularios.auth.login_form')
            </div>
            </div>
            </div>



        </div>
       </div>




@stop

@section('vue-logica')




<script type="text/javascript">
    @include('empresa_gestion_paginas.Vue_logica.Componentes.Helpers.erroresMixin')
    @include('empresa_gestion_paginas.Vue_logica.instancia_vue')
</script>

@stop
