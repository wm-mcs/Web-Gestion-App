@extends('layouts.admin_layout.admin_layout')


@section('miga-de-pan') 
  {{-- lugar atras --}}
  <a href="{{route('get_admin_productos')}}"><span>Productos</span></a>

  {{-- separador --}}
  <span class="spam-separador">|</span> 

  {{-- lugar donde esta --}}
  <span>Editar: {{$Entidad->name}}</span>
@stop

@section('content')



 <div class="contenedor-img-titulo">
   <img class="admin-entidad-img" src="{{$Entidad->url_img}}">
   {{-- titulo --}}
   {{-- <div class="admin-entidad-titulo">Editar Evento {{$Evento->name}}</div> --}}
 </div>
 
   
 


 

 {{-- formulario --}}
  {!! Form::model($Entidad,   ['route' => ['set_admin_productos_editar',$Entidad->id],
                            'method'=> 'patch',
                            'files' =>  true,
                            'id'    => 'form-admin-empresa-datos'
                          ])               !!}




   <div class="formulario-contenedor">


    {{-- datos corporativos --}}
      <div class="contenedor-grupo-datos">
        <div class="contenedor-grupo-datos-titulo"> Datos</div>
        <div class="contenedor-formulario-label-fiel">                       
         @include('admin.productos.formularios_partes.datos_basicos')

        

        
        </div>
      </div>

     


      {{-- datos imagenes --}}
      <div class="contenedor-grupo-datos">
        <div class="contenedor-grupo-datos-titulo"> Imágenes</div>
        <div class="contenedor-formulario-label-fiel"> 
          @include('admin.productos.partes.parte_imagenes_adicionales')                      
          @include('admin.productos.formularios_partes.datos_imagenes')
        </div>
      </div>
   </div>
   {!! Form::hidden('tipo_de_boton','hola') !!}
   
   <div class="admin-boton-editar">
     Editar 
   </div> 
   
   {{-- <a href="">Eliminar </a> --}}


  {!! Form::close() !!} 


  

  
@stop