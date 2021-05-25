@extends('layouts.gestion_socios_layout.public_layout')






@section('content')


<div style="min-height: 100vh;" class="w-100 ">
        <div class="container d-flex flex-column align-items-center">

                <div class="col-10 col-lg-5 d-flex flex-column align-items-center">
                         <img src="{{$Empresa->url_img}}" alt="Logo de {{$Empresa->name}}" class="img-fluid">
                </div>

                <p>
                   Reservá tu clase en {{$Empresa->name}}
                </p>

                <componente-general-reservas :empresa="empresa" default-que-mostrar="reserva"></componente-general-reservas>

        </div>
       </div>
</div>




@stop

@section('vue-logica')




<script type="text/javascript">
   @include('empresa_gestion_paginas.Vue_logica.Componentes.Helpers.erroresMixin')
    @include('empresa_gestion_paginas.Vue_logica.Componentes.Helpers.onKeyPressMixIn')
    @include('empresa_gestion_paginas.Vue_logica.Componentes.EmpresaReservasYPanelSocioPublico.Componentes.reservas')
    @include('empresa_gestion_paginas.Vue_logica.Componentes.EmpresaReservasYPanelSocioPublico.Componentes.componenteGeneralDeReservas')
    @include('empresa_gestion_paginas.Vue_logica.instancia_vue')
</script>

@stop
