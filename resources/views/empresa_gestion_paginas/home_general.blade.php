@extends('layouts.gestion_socios_layout.admin_layout')


@section('miga-de-pan') 
 
@stop

@section('content')
  

    
  
 <mostrar-empresas></mostrar-empresas>












@stop

@section('vue-logica')


<script type="text/javascript">


     
     @include('empresa_gestion_paginas.Vue_logica.Componentes.Admin.mostrar_empresas')    
     @include('empresa_gestion_paginas.Vue_logica.Componentes.Admin.empresa_lista')     
     
     @include('empresa_gestion_paginas.Vue_logica.instancia_vue')



</script>

@stop


@section('columna')

  
  @include('admin.empresas_gestion_socios.columna_derecha.columna_logo_easy_socios')
  

  @include('admin.empresas_gestion_socios.columna_derecha.columna_operario')
  @include('admin.empresas_gestion_socios.columna_derecha.columna_dueño_empresa')
  @include('admin.empresas_gestion_socios.columna_derecha.columna_vendedor')
  @include('admin.empresas_gestion_socios.columna_derecha.columna_super_admin')
@stop