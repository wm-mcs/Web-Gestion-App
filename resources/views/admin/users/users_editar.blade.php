@extends('layouts.gestion_socios_layout.admin_layout')


@section('miga-de-pan')
 

  {{-- lugar atras --}}
  <a href="{{route('get_admin_users')}}"><span>Usuarios</span></a>

  {{-- separador --}}
  <span class="spam-separador">|</span> 
  
  {{-- lugar donde esta --}}
  <span>Editar a {{$user->name}}</span>
@stop



@section('content')





 {{-- formulario --}}
  {!! Form::model($user,   ['route' => ['set_admin_users_editar',$user->id],
                            'method'=> 'patch',
                            'files' =>  true,
                            'id'    => 'form-admin-empresa-datos'
    

                          ])               !!}


<div class="wrpaer-formulario-contenedor">                        
   <div class="formulario-contenedor">
     <div class="formulario-contenedor-columnas">
      {{-- datos corporativos --}}
      <div class="contenedor-grupo-datos">
        <div class="contenedor-grupo-datos-titulo"><span class="icon-person"></span> Identidad</div>
        <div class="contenedor-formulario-label-fiel">                       
          @include('admin.users.formularios_partes.datos_user')
        </div>
      </div>
    </div>

     <div class="formulario-contenedor-columnas">
      {{-- imagenes corporativos --}}
      <div class="contenedor-grupo-datos">
        <div class="contenedor-grupo-datos-titulo"><span class="icon-person"></span> Estado y Rol</div>
        <div class="contenedor-formulario-label-fiel">                       
          @include('admin.users.formularios_partes.datos_user_select')
        </div>
      </div>
    </div>

      

      
   </div>
   <div class="admin-boton-editar">
     Editar Usuario
   </div> 

</div>
  {!! Form::close() !!}


  

  
@stop


@section('columna')

 @include('admin.empresas_gestion_socios.columna_derecha.columna_logo_easy_socios')

  @include('admin.empresas_gestion_socios.columna_derecha.columna_operario')
  @include('admin.empresas_gestion_socios.columna_derecha.columna_dueño_empresa')
  @include('admin.empresas_gestion_socios.columna_derecha.columna_vendedor')
  @include('admin.empresas_gestion_socios.columna_derecha.columna_super_admin')
@stop


@section('vue-logica')


<script type="text/javascript">

   
@include('empresa_gestion_paginas.Vue_logica.instancia_vue')   



</script>

@stop