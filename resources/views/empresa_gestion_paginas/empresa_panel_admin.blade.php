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

   <div class="empresa-contendor-de-secciones">
      <div class="estado-de-cuenta-titulo-saldo-contenedor ">

          <span class="empresa-titulo-de-secciones">Estado de cuenta del socio</span>

          <estado-de-cuenta-empresa-saldo :empresa="empresa" > </estado-de-cuenta-empresa-saldo>
      </div>
      <div class="contiene-estados-de-cuenta-lista">
        
          


             <estado-de-cuenta-empresa-lista v-for="estado in empresa.movimientos_estado_de_cuenta_empresa" 
                                   :estado_de_cuenta="estado" 
                                   :empresa="empresa"                                  
                                   :key="estado.id"
                                   >
                                     
             </estado-de-cuenta-empresa-lista>


         

          
            
          

      </div>
  </div>

  
  












@stop

@section('vue-logica')


<script type="text/javascript">
       
     @include('empresa_gestion_paginas.Vue_logica.Componentes.Admin.tipo-de-servicios-empresa')
     @include('empresa_gestion_paginas.Vue_logica.Componentes.EmpresaAdminPanel.estado-de-cuenta-empresa-saldo')  
     @include('empresa_gestion_paginas.Vue_logica.Componentes.EmpresaAdminPanel.estado-de-cuenta-empresa-lista')
     @include('empresa_gestion_paginas.Vue_logica.Componentes.EmpresaAdminPanel.ingresar-movimiento-a-empresa')
     @include('empresa_gestion_paginas.Vue_logica.instancia_vue')



</script>

@stop


@section('columna')

  
  @include('admin.empresas_gestion_socios.columna_derecha.columna_logo_easy_socios')
  

  
  @include('admin.empresas_gestion_socios.columna_derecha.columna_vendedor')
  @include('admin.empresas_gestion_socios.columna_derecha.columna_super_admin')

 
@stop