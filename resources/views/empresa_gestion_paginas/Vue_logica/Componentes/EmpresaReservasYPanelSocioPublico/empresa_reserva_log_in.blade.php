@extends('layouts.gestion_socios_layout.public_layout')






@section('content')


<div style="min-height: 100vh;" class="w-100 d-flex flex-row align-items-center justify-content-center">
        <div class="w-100 d-flex flex-column align-items-center">

          <div class="">
            @include('layouts.gestion_socios_layout.mensajes.mensajes')
          </div>

          <div class="container d-flex flex-row align-items-center justify-content-center">
            <div class="w-100 d-flex flex-column align-items-center p-2  ">
                <div class="col-6 col-lg-4 p-2 p-lg-2  ">
                    <img class="img-fluid " src="{{$Data['img']}}">
                </div>

                <div class="col-11 col-lg-5 background-gris-0  p-3 p-lg-5 ">
                <h1 class="sub-titulos-class font-secondary text-color-black text-center  mb-3"> <strong>{{$Data['title']}}</strong> </h1>
                <p class="col-12 text-center mb-3">
                  <small>Para ingresar escribí tu celular <br> y apretá el botón de abajo.</small>
                </p>
                {!! Form::open(             ['route' => 'post_auth_login_reserva_socio',
                            'method'   => 'post',
                            'files'    => true
                            ])               !!}


                            <div class="">
                              <div class="formulario-label-fiel">
                                  <fieldset class="float-label">
                                    <input
                                      name="celular"
                                      type="number"
                                      class="input-text-class-primary"


                                    />
                                    <label for="celular">Tu celular</label>
                                  </fieldset>
                                </div>


                                <div class="mt-3 ">
                                  <button @click="cargando = !cargando" v-if="!cargando " type="submit" class="Boton-Primario-Relleno Boton-Fuente-Chica">Ingresar </button>
                                  <div  v-else class="h4 text-center color-text-gris">
                                      Procesando
                                  </div>
                                </div>

                            </div>
                {!! Form::close() !!}
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
