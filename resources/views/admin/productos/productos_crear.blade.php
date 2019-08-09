@extends('layouts.admin_layout.admin_layout')

@section('miga-de-pan') 
  {{-- lugar atras --}}
  <a href="{{route('get_admin_productos')}}"><span>Productos</span></a>

  {{-- separador --}}
  <span class="spam-separador">|</span> 

  {{-- lugar donde esta --}}
  <span>Crear Evento</span>
@stop

@section('content')





 {{-- formulario --}}
  {!! Form::open(['route' => 'set_admin_productos',
                            'method'=> 'post',
                            'files' =>  true,
                            'id'    => 'form-admin-empresa-datos'
                          ])               !!}
   <div class="formulario-contenedor">
      {{-- datos corporativos --}}
      <div class="contenedor-grupo-datos">
        <div class="contenedor-grupo-datos-titulo"> Datos</div>
        <div class="contenedor-formulario-label-fiel">                       
          @include('admin.productos.formularios_partes.datos_basicos')
          {{-- fecha del evento --}}        
        </div>
      </div>

     
      {{-- datos imagenes --}}
      <div class="contenedor-grupo-datos">
        <div class="contenedor-grupo-datos-titulo">Imagenes</div>
        <div class="contenedor-formulario-label-fiel">                       
          @include('admin.productos.formularios_partes.datos_imagenes')
        </div>
      </div>      
   </div>

    {!! Form::hidden('tipo_de_boton','hola') !!}
   
   <div class="admin-boton-editar">
     Crear 
   </div> 
   


  {!! Form::close() !!}


  

  
@stop