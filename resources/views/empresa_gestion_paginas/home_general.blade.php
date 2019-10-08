@extends('layouts.gestion_socios_layout.admin_layout')


@section('miga-de-pan') 
 
@stop

@section('content')
  

    
  
 <div class="admin-contiene-entidades-y-pagination">
   <div class="admin-entidad-contenedor-entidades">
      
    @foreach($Empresas as $empresa)
      <div class="empresa-lista-contenedor">
        <div class="empresa-lista-header">
          <div class="empresa-lista-contiene-img">
            <img src="{{$empresa->url_img}}" class="empresa-lista-img">
          </div>
          
          <div class="simula_link" > {{$empresa->name}}</div> 
        </div>
        <div class="empresa-lista-header">
         @foreach($empresa->sucursuales_empresa as $sucursal)          
          @if($sucursal->puede_ver_el_user)
            <div class="empresa-lista-contiene-img">
              <div>{{$sucursal->name}}</div>
            </div>
          @endif
         @endforeach
          
          <div class="simula_link" > {{$empresa->name}}</div> 
        </div>
  
      @endforeach
  </div> 


   </div>
   <div>
    
   </div>
 </div>












@stop

@section('vue-logica')


<script type="text/javascript">


     
     @include('empresa_gestion_paginas.Vue_logica.Componentes.Admin.mostrar_empresas')    
     @include('empresa_gestion_paginas.Vue_logica.Componentes.Admin.empresa_lista')     
     
     @include('empresa_gestion_paginas.Vue_logica.instancia_users_vue')



</script>

@stop


@section('columna')

  
  @include('admin.empresas_gestion_socios.columna_derecha.columna_logo_easy_socios')
  

  @include('admin.empresas_gestion_socios.columna_derecha.columna_operario')
  @include('admin.empresas_gestion_socios.columna_derecha.columna_dueño_empresa')
  @include('admin.empresas_gestion_socios.columna_derecha.columna_vendedor')
  @include('admin.empresas_gestion_socios.columna_derecha.columna_super_admin')
@stop