<!DOCTYPE html>
<html lang="es">
  <head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">

   @yield('og-tags')

   <link rel="shortcut icon" href="{{ asset('imagenes/favicon.ico') }}"> 

   <meta property="og:type"               content="website" />
   <meta property="og:title"              content="{{ $Titulo}} " />
   <meta property="og:description"        content="{{$DescriptionEtiqueta}}" />
   <meta property="og:image"             content="{{$ImagenParaTaG }}" />
   <meta property="og:image:secure_url"  content="{{$ImagenParaTaG }}" /> 
   <meta property="og:image:width" content="250">    
    

   <title> @yield('title') | EasySocio</title>
   <meta name="Description" CONTENT="@yield('MetaContent')">      
   <META name="robots" content="@yield('MetaRobot')">
   <meta name="Keywords"  content="@yield('palabras-claves')">

   {{-- css --}}   
   @include('layouts.user_layout.css_fonts')
  </head>
    
  <body> 
    <span id="app">
       <div class="w-100 d-flex flex-column align-items-center">
        <div class="mensaje-contenedor-layout-auth">
          @include('layouts.gestion_socios_layout.mensajes.mensajes')   
        </div>
        <div class="w-100 d-flex flex-column align-items-center">
          @yield('content')  
        </div>
       </div>  
   </span>
   <!-- Scripts -->
   <script src="{{url()}}{{ elixir('js/admin.js')}} " ></script> 
  </body>
</html>   