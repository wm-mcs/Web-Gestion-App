@extends('layouts.admin_layout.admin_layout')


@section('miga-de-pan') 
  {{-- lugar atras --}}
  <a href="{{route('get_admin_empresas_gestion_socios')}}"><span>Empresas</span></a>

  {{-- separador --}}
  <span class="spam-separador">|</span> 

  {{-- lugar donde esta --}}
  <span>Crear</span>
@stop

@section('content')





 {{-- formulario --}}
  {!! Form::open(['route' => 'set_admin_empresas_gestion_socios_crear',
                            'method'=> 'POST',
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
        <div class="contenedor-grupo-datos-titulo"> Imagen</div>
        <div class="contenedor-formulario-label-fiel">                       
          @include('admin.empresas_gestion_socios.formularios_partes.datos_imagenes')
        </div>
      </div>

      

      
   </div>
   <div class="admin-boton-editar">
     Crear
   </div> 

  {!! Form::close() !!}


  

  
@stop