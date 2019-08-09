@extends('layouts.user_layout.user_layout')



@section('og-tags')
<meta property="og:title" content="{{$Entidad->name}}">
     <meta property="og:description" content=" {{$Entidad->description}}">
     <meta property="og:image" content=" {{$Entidad->url_img}}">
     <meta property="og:url" content=" {{$Entidad->route}}">
@stop


@section('title')
   {{$Entidad->name}}   | {{$Empresa->name}}
@stop


@section('MetaContent')
   {{$Entidad->description}}  | {{$Empresa->name}}
@stop

@section('MetaRobot')

@stop

@section('palabras-claves')
  
@stop



@section('content')

 <div class="contenedor-listado-noticias">  
  <div class="col-lg-12 text-center">
     <h1 class="text-uppercase text-color-black" style="margin-top:78px;">
        <strong> {{$Entidad->name}}</strong>
     </h1>
     <hr class="my-4"> 
  </div>  
  


  <div class="producto-individual-contenedor-imgs" >
    @foreach($Entidad->imagenes_producto as $Img)
     <div class="producto-individual-img-contendor">
       <img data-flickity-lazyload="{{$Img->url_img}}" class="producto-individual-img">
     </div>    
    @endforeach
  </div>


  {{-- description --}}
  <div class="producto-individual-descripcion">
    {{$Entidad->description}}
  </div>

  {{-- precio --}}
   <div class="producto-individual-precio">
      <div class="flex-row-center ">
        <div class="flex-row-center" >
          <span class="producto-individual-moneda">{{$Entidad->moneda}}</span> 
          <span class="producto-individual-precio-valor">{{$Entidad->precio_producto}}</span>         
        </div>   
      </div>
  </div>

 {{-- aclaro que tengo o no --}}
  @if($Entidad->stock > 0)
    <div class="producto-individual-aclaracion-stock">
        En stock: listo para entrega o envio inmediato <i class="far fa-grin"></i>
    </div>

  @else
    <div class="producto-individual-aclaracion-no-stock producto-individual-aclaracion-stock">
        Fuera de stock pero por llegar <i class="far fa-grin"></i>
    </div>
  @endif 

  {{-- llamada a la accion --}}
  <div class="producto-individual-precio">

    <div class="flex-row-center  flex-wrap">
      <div class="flex-row-center">
        <div class="producto-individual-pregunta">¿Te interesa?</div>        
      </div>
      <div class="flex-row-center">
         <a href="https://api.whatsapp.com/send?phone={{$Empresa->numero_whatsapp_ya_arreglado}}&text=Hola!%20tengo%20interes%20en%20{{$Entidad->route}}"> 
           <div class="boton-simple-chico"> Contáctame ahora <i class="fab fa-whatsapp"></i> </div>
         </a>        
      </div>

    </div>
    
  </div>


  



  </div>

  


@stop