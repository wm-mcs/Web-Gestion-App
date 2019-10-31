@extends('layouts.gestion_socios_layout.admin_layout')


@section('miga-de-pan') 


  <span> Panel administrador de general de {{$Empresa->name}}</span>
@stop

@section('sucursal')  
 
@stop

@section('content')
  

    
  
   <div class="panel-socio-header-contenedor">
    <div class="panel-socio-name">

        {{$Empresa->name}}

    </div>
    <div class="panel-socio-contiene-acciones"> 

     <ingresar-movimiento-a-empresa  :empresa="empresa" ></ingresar-movimiento-a-empresa> 
     
     
      
     

    </div>


  </div>

  
  












@stop

@section('vue-logica')


<script type="text/javascript">
     

     @include('empresa_gestion_paginas.Vue_logica.Componentes.EmpresaAdminPanel.ingresar-movimiento-a-empresa')
     @include('empresa_gestion_paginas.Vue_logica.instancia_vue')



</script>

@stop


@section('columna')

  
  @include('admin.empresas_gestion_socios.columna_derecha.columna_logo_easy_socios')
  

  
  @include('admin.empresas_gestion_socios.columna_derecha.columna_vendedor')
  @include('admin.empresas_gestion_socios.columna_derecha.columna_super_admin')

 
@stop