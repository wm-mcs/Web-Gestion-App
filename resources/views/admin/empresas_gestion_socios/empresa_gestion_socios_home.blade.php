@extends('layouts.gestion_socios_layout.admin_layout')


@section('miga-de-pan')

  <span>Empresas Gestion</span>
@stop

@section('content')

<div class="contenedor-admin-entidad-titulo-form-busqueda">
    <div class="admin-entidad-titulo">
     <a href="{{route('get_admin_empresas_gestion_socios_crear')}}">
      <span class="admin-user-boton-Crear">Crear </span>
     </a>
    </div>
    @include('admin.empresas_gestion_socios.partes.buscador')
 </div>


 <mostrar-empresas></mostrar-empresas>







@stop

@section('vue-logica')


<script type="text/javascript">


@include('empresa_gestion_paginas.Vue_logica.Componentes.EmpresaAdminPanel.estado-de-cuenta-empresa-saldo')
@include('empresa_gestion_paginas.Vue_logica.Componentes.Admin.mostrar_empresas')
@include('empresa_gestion_paginas.Vue_logica.Componentes.Admin.empresa_lista')
@include('empresa_gestion_paginas.Vue_logica.instancia_vue')



</script>

@stop



@section('columna')

 @include('admin.empresas_gestion_socios.columna_derecha.columna_logo_easy_socios')


@stop
