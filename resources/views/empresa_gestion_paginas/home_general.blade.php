@extends('layouts.gestion_socios_layout.admin_layout')


@section('miga-de-pan') 
 
@stop

@section('content')
  
<div class="admin-contiene-entidades-y-pagination">
 @if($Empresas->count() > 0)

 <div class="empresa-gestion-texto-gris-grande-de-aviso">
   
   @if($Empresas->count() == 1)
     Clic para ingresar <i class="far fa-hand-point-down"></i>

   @endif
 </div>
  
 
   <div class="admin-entidad-contenedor-entidades">
      
    @foreach($Empresas as $empresa)
      <div class="empresa-lista-user-contenedor">
        <div class="empresa-lista-user-header">
          <div class="empresa-lista-user-contiene-img">
            <img src="{{$empresa->url_img}}" class="empresa-lista-user-img">
          </div>
           @foreach($empresa->sucursuales_empresa as $sucursal)          
            @if($sucursal->puede_ver_el_user)
              <div class="empresa-lista-user-sucursal">
                <div class="empresa-lista-user-sucursal-entrar">Entrar a sucursal</div>
                 {!! Form::open(['route' => ['get_empresa_panel_de_gestion'],
                            'method'=> 'Post',
                            'files' =>  true,
                            'name'  => 'form1'
                          ])               !!}   
                 <input type="hidden" name="empresa_id" value="{{$empresa->id}}">
                 <input type="hidden" name="sucursal_id" value="{{$sucursal->id}}">
                 <span class="simula_link empresa-lista-user-sucursal-nombre disparar-este-form" >{{$sucursal->name}}</span>    

                 {!! Form::close() !!}  
                
              </div>
            @endif
           @endforeach
        </div>
    </div> 
   @endforeach

   </div>  
 
 @else
  <div class="empresa-gestion-texto-gris-grande-de-aviso">   
   En breve tendrás acceso a una empresa 
 </div>
 @endif
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
  

  
@stop