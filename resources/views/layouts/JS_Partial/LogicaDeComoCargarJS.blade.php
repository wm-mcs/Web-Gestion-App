
<script src="{{url()}}{{ elixir('js/admin.js')}} " ></script>  

@if(Auth::guest())
        <script  src="https://unpkg.com/vue@2.5.17/dist/vue.min.js"></script> 
@else
    @if(Auth::user()->role > 1)
        <script  src="https://unpkg.com/vue@2.5.17/dist/vue.js"></script> 
    @else
        <script  src="https://unpkg.com/vue@2.5.17/dist/vue.min.js"></script> 
    @endif
@endif
<script  src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script> 
<script  src="https://cdnjs.cloudflare.com/ajax/libs/vue-select/2.6.2/vue-select.js"></script>
<script  src="https://unpkg.com/lodash@4.13.1/lodash.min.js"></script>


<script type="text/javascript">
    @include('empresa_gestion_paginas.Vue_logica.Componentes.Layout.inicio') 
</script>


@yield('vue-logica')   