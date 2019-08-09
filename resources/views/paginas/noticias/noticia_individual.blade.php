@extends('layouts.user_layout.user_layout')



@section('og-tags')
  <meta property="og:url"                content="{{$Noticia->route}}" />
  <meta property="og:type"               content="website" />
  <meta property="og:title"              content="{{ $Noticia->name}} | {{$Empresa->name}}" />
  <meta property="og:description"        content="
   {{$Noticia->sub_name}} | {{$Empresa->name}}." />
   <meta property="og:image"               content="{{$Noticia->url_img_portada}}" />
   <meta property="og:image:secure_url"  content="{{$Noticia->url_img_portada}}" /> 

   <meta property="og:image:alt"         content="{{$Noticia->name}} |  {{$Empresa->name}}" /> 
@stop


@section('title')
  {{ $Noticia->name}}    | {{$Empresa->name}}
@stop


@section('MetaContent')
 {{$Noticia->sub_name}} |  {{$Empresa->name}} 
@stop

@section('MetaRobot')
  index,follow
@stop

@section('palabras-claves')
  
@stop


@section('iconos-compartir')

 <div v-show="scrolled" on-scroll="handleScroll" class="get_width_100 contenedor-iconos-share">
  

 <div class="flex-row-center sub-contenedor-iconos-share">

    <div class="iconos-share-titulo"><i class="fas fa-share-alt"></i> Compartir</div>
    

    {{-- //whatzap icono --}}
    <a class="iconos-share-formato mostrar-solo-mobil" href="whatsapp://send?text={{$Noticia->route}}" data-action="share/whatsapp/share">
            <i class="fab fa-whatsapp-square"></i>
    </a>


    <a class="iconos-share-formato" href="http://facebook.com/sharer.php?u={{$Noticia->route}}">
            <i class="fab fa-facebook"></i>
    </a>

    <a class="iconos-share-formato" href="https://www.linkedin.com/shareArticle?url={{$Noticia->route}}">
            <i class="fab fa-linkedin"></i>
    </a>

    <a class="iconos-share-formato" href="https://twitter.com/?status=Me gusta esta página {{$Noticia->route}}">
            <i class="fab fa-twitter-square"></i>
    </a>
   
 </div> 



</div>

@endsection



@section('content')

<div  class="{{-- masthead --}} get_width_100 "  >
  
<div id="carouselExampleIndicators" class="carousel slide auto" data-ride="carousel" data-interval="5000">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    
  </ol>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img class="post-img-slider-size Slider_cabecer_img" data-src="{{$Noticia->url_img_portada}}"> 
     
    </div>
   
  </div>


      <div class="carousel-caption  Slider-Contendor d-md-block Helper-OrdenarHijos-Row">
        <div class="get_width_100 flex-row-center" style="min-height: 100vh;">
          <div class="get_width_100">
              <div class="col-lg-10 mx-auto">
                <h1 class="text-uppercase Slider_cabecera_caption_titulo text-color-black">
                  <strong>{{$Noticia->name}}</strong>
                </h1>
               </div>  
          </div>
        </div>
      </div>
      {{-- <img src="{{url()}}/imagenes/580b57fcd9996e24bc43c513.png" class="Slider_cabecera_caption_logo">   --}}
  

</div>
</div>

  


   <div class="contenedor-listado-noticias" id="contenido-noticia">  
    
       {{html_entity_decode($Noticia->contenido_render)}}

   </div>

  


@stop