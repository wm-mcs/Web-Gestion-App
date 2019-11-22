@extends('layouts.gestion_socios_layout.admin_layout')


@section('miga-de-pan') 
 
@stop

@section('content')


@if(Auth::user()->role > 3)
<div class="contenedor-admin-entidad-titulo-form-busqueda">
  <crear-empresa></crear-empresa>
</div>
@endif
  
<div class="admin-contiene-entidades-y-pagination">
@if($Empresas->count() > 0)

 <div class="empresa-gestion-texto-gris-grande-de-aviso">
   
   @if($Empresas->count() == 1)
     Click para ingresar <i class="far fa-hand-point-down"></i>

   @else
     Click para ingresar <i class="far fa-hand-point-down"></i>
   @endif
 </div>
  
 
  
      
   <mostrar-empresas></mostrar-empresas>

   
 
 @else
  <div class="empresa-gestion-texto-gris-grande-de-aviso">   
   En breve tendrás acceso a una empresa 
 </div>
 @endif
 </div>












@stop

@section('vue-logica')


<script type="text/javascript">

     @include('empresa_gestion_paginas.Vue_logica.Componentes.EmpresaAdminPanel.estado-de-cuenta-empresa-saldo')    
     @include('empresa_gestion_paginas.Vue_logica.Componentes.Admin.tipo-de-servicios-empresa')
     @include('empresa_gestion_paginas.Vue_logica.Componentes.Admin.crear-empresa')
     @include('empresa_gestion_paginas.Vue_logica.Componentes.Layout.configuracion-empresa')
     @include('empresa_gestion_paginas.Vue_logica.Componentes.Admin.mostrar_empresas')    
     @include('empresa_gestion_paginas.Vue_logica.Componentes.Admin.empresa_lista')     
     
     @include('empresa_gestion_paginas.Vue_logica.instancia_users_vue')



</script>

@stop


@section('columna')

  
  @include('admin.empresas_gestion_socios.columna_derecha.columna_logo_easy_socios')
  @include('admin.empresas_gestion_socios.columna_derecha.columna_super_admin')

  
@stop