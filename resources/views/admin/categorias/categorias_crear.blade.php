@extends('layouts.admin_layout.admin_layout')


@section('miga-de-pan') 
  {{-- lugar atras --}}
  <a href="{{route('get_admin_categorias')}}"><span>Categorias</span></a>

  {{-- separador --}}
  <span class="spam-separador">|</span> 

  {{-- lugar donde esta --}}
  <span>Crear categoria</span>
@stop

@section('content')





 {{-- formulario --}}
  {!! Form::open(['route' => 'set_admin_categorias_crear',
                            'method'=> 'post',
                            'files' =>  true,
                            'id'    => 'form-admin-empresa-datos'
                          ])               !!}
   <div class="formulario-contenedor">

      {{-- datos corporativos --}}
      <div class="contenedor-grupo-datos">
        <div class="contenedor-grupo-datos-titulo"> Datos</div>
        <div class="contenedor-formulario-label-fiel">                       
          @include('admin.categorias.formularios_partes.datos_basicos')
        </div>
      </div>

    

      

      
   </div>
   <div class="admin-boton-editar">
     Crear
   </div> 

  {!! Form::close() !!}


  

  
@stop