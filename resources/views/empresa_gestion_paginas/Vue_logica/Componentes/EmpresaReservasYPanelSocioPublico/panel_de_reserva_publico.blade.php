@extends('layouts.gestion_socios_layout.public_layout')






@section('content')


<div style="min-height: 100vh;" class="w-100 d-flex flex-row align-items-center justify-content-center">
        <div class="w-100 d-flex flex-column align-items-center">
                Panel de reserva
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
