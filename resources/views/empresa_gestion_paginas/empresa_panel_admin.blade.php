@extends('layouts.gestion_socios_layout.admin_layout')


@section('miga-de-pan') 
 

  <a href="{{route('get_home')}}"><i class="fas fa-home"></i></a>
  <span class="spam-separador"><i class="fas fa-chevron-right"></i></span>

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
     
     
    <agregar-servicio-a-empresa :empresa="empresa"></agregar-servicio-a-empresa>
     

    </div>


   </div>
    <div  v-if="empresa.servicios_de_renovacion_empresa.length" class="empresa-contendor-de-secciones">
      <div class="empresa-titulo-de-secciones">Planes más frecuentemente comprados. Se usan para cargar de forma rápido o renovación automática </div>
      <div class="panel-socio-contiene-servicios">
        
          


            <servicio-renovacion-empresa-lista  
                                  
                                  :servicio_renovacion="servicio_renovacion"
                         

                           v-for="servicio_renovacion in empresa.servicios_de_renovacion_empresa" :key="servicio_renovacion.id"> 
            </servicio-renovacion-empresa-lista>  
            
          

      </div>
  </div>
   <div v-else class="cuando-no-hay-socios">
    No hay servicios renovación creados <i class="far fa-frown"></i>
  </div>


    <div  v-if="empresa.servicios_contratados_a_empresas_activos.length" class="empresa-contendor-de-secciones">
      <div class="empresa-titulo-de-secciones">Servicios que contrató <span class="color-text-success">disponibles</span> </div>
      <div class="panel-socio-contiene-servicios">
        
          


            <servicio-empresa-lista :servicio="servicio" 
                                     :empresa="empresa"           
                         

                           v-for="servicio in empresa.servicios_contratados_a_empresas_activos" :key="servicio.id"> 
            </servicio-empresa-lista>  
            
          

      </div>
  </div>
  <div v-else class="cuando-no-hay-socios">
    No hay servicios disponibles <i class="far fa-frown"></i>
  </div>

   <div  v-if="empresa.servicios_contratados_a_empresas_desactivos.length" class="empresa-contendor-de-secciones">
      <div class="empresa-titulo-de-secciones">Servicios que contrató No disponibles </div>
      <div class="panel-socio-contiene-servicios">
        
          


            <servicio-empresa-lista :servicio="servicio" 
                                     :empresa="empresa"           
                         

                           v-for="servicio in empresa.servicios_contratados_a_empresas_desactivos" :key="servicio.id"> 
            </servicio-empresa-lista>  
            
          

      </div>
  </div>
  <div v-else class="cuando-no-hay-socios">
   Nada aún 
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

     @include('empresa_gestion_paginas.Vue_logica.Componentes.Admin.paises')
     @include('empresa_gestion_paginas.Vue_logica.Componentes.Admin.tipo-de-servicios-empresa')
     @include('empresa_gestion_paginas.Vue_logica.Componentes.EmpresaAdminPanel.servicio-empresa-lista')
     @include('empresa_gestion_paginas.Vue_logica.Componentes.EmpresaAdminPanel.agregar-servicio-a-empresa')
     @include('empresa_gestion_paginas.Vue_logica.Componentes.EmpresaAdminPanel.servicio-renovacion-empresa-lista')  
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