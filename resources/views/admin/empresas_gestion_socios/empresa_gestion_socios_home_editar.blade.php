@extends('layouts.admin_layout.admin_layout')

@section('miga-de-pan') 
  {{-- lugar atras --}}
  <a href="{{route('get_admin_empresas_gestion_socios')}}"><span>Empresas</span></a>

  {{-- separador --}}
  <span class="spam-separador">|</span> 

  {{-- lugar donde esta --}}
  <span>Editar</span>
@stop

@section('content')

 {{-- titulo --}}
 <div class="contenedor-admin-entidad-titulo-form-busqueda">
    <div class="admin-entidad-titulo"> 
     <a href="{{$Entidad->route_panel_empresa}}">
       <span class="admin-user-boton-Crear">Vista de cliente</span>
     </a>  
    </div>
    
 </div>



  {{-- formulario --}}
  {!! Form::model($Entidad,   ['route' => ['set_admin_empresas_gestion_socios_editar',$Entidad->id],
                            'method'=> 'PATCH',
                            'files' =>  true,
                            'id'    => 'form-admin-empresa-datos'
                          ])               !!}
   <div class="formulario-contenedor">

      {{-- datos corporativos --}}
      <div class="contenedor-grupo-datos">
        <div class="contenedor-grupo-datos-titulo"> Datos</div>
        <div class="contenedor-formulario-label-fiel">                       
         @include('admin.empresas_gestion_socios.formularios_partes.datos_basicos')
        </div>
      </div>

      {{-- imagenes corporativos --}}
      <div class="contenedor-grupo-datos">
        <div class="contenedor-grupo-datos-titulo">Imagen</div>
        <div class="contenedor-formulario-label-fiel">                       
          @include('admin.empresas_gestion_socios.formularios_partes.datos_imagenes')
        </div>
      </div>

      

      
   </div>
   <div class="admin-boton-editar">
     Guardar
   </div> 

  {!! Form::close() !!}
  
@stop