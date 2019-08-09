@extends('layouts.admin_layout.admin_layout')

@section('content')

<div class="admin-contnedor-navegacion-miga">
  {{-- home --}}
  <a href="{{route('get_admin_home')}}"><span class="icon-home"></span></a>

  {{-- separador --}}
  <span class="spam-separador">|</span> 

  {{-- lugar atras --}}
  
  {{-- lugar donde esta --}}
  <span>Editar Usuario: Editar Imagen</span>
</div>


<div class="contenedor-admin-entidad">

 {{-- titulo --}}
 <div class="admin-entidad-titulo">Editar Usuario 
 </div>

 {{-- formulario --}}
  {!! Form::model($Imagen,   ['route' => ['edit_img_home',$Imagen->id],
                            'method'=> 'patch',
                            'files' =>  true,
                            'id'    => 'form-admin-empresa-datos'
                          ])               !!}
   <div class="formulario-contenedor">

      {{-- datos corporativos --}}
      <div class="contenedor-grupo-datos">
        <div class="contenedor-grupo-datos-titulo"><span class="icon-person"></span> Editar Imagen</div>
        <div class="contenedor-formulario-label-fiel">                       
          @include('admin.home.formularios_partes.datos_imagenes')
          <div class="formulario-label-fiel">
            {!! Form::label('estado', 'Estado', array('class' => 'formulario-label ')) !!}
            {!! Form::select('estado',['si' => 'Activo',
                                       'no' => 'Desactivar'] , null )          !!}
          </div>
        </div>
      </div>
      
   </div>
   <div class="admin-boton-editar">
     Editar Imagen
   </div> 


  {!! Form::close() !!}


  
</div>
  
@stop