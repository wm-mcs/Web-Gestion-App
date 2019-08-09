@extends('layouts.user_layout.user_layout')



@section('og-tags')
{{-- <meta property="og:title" content="Global Target">
     <meta property="og:description" content="Agencia de modelos, eventos y promociones.">
     <meta property="og:image" content="https://www.globaltarget.com.uy/thumbnail.jpg">
     <meta property="og:url" content="https://www.globaltarget.com.uy/"> --}}
@stop


@section('title')
   Productos   | {{$Empresa->name}}
@stop


@section('MetaContent')

@stop

@section('MetaRobot')

@stop

@section('palabras-claves')

@stop



@section('content')

  
  <div class="col-lg-12 text-center">
     <h1 class="text-uppercase text-color-black" style="margin-top:78px;">
        <strong>Lista de precios</strong>
     </h1>
     <hr class="my-4">
     <h4 class="text-muted mb-4">Nos adaptamos a tus preferencias.</h4>

  </div>
  
  

  <div class="contenedor-listado-noticias">


    @foreach($Categorias as $Categoria)

     <h2 class="producto-lista-categoria-name">{{$Categoria->name}}</h2>   

     @foreach($Categoria->productos_categoria as $Entidad)
    
      @include('paginas.productos.producto_individual_tipo_lista')   

     @endforeach

     <hr class="my-8">
    @endforeach 

  </div>

  


@stop