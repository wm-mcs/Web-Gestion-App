<!DOCTYPE html>
<html lang="es">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    

    <title>@yield('titulo')</title>
    <meta name="Description" content="@yield('descripcion')">      
    <meta name="robots" content="@yield('robot')">
    <meta name="keywords" content="@yield('palabras_claves')">

    {{-- css --}}   
    @include('layouts.user_layout.css_fonts')

 

  </head>

  <body id="page-top">

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top " id="mainNav">
      <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="#page-top"><img style="height:35px; " alt="{{$Empresa->name}}" src="{{$Empresa->img_logo_cuadrado}}"></a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
          @yield('nav')
          @include('paginas.home.home_nav_auth')
          </ul>
        </div>
      </div>
    </nav>
    


    @yield('slider')

    <span id="app">

     @yield('contenido') 
   
     
      
      @include('paginas.home.home_footer')
      

          {{-- <div class="col-sm-10"> 
    <h1>JSON</h1>
    <pre>
      @{{$data}}
    </pre>
  </div> --}}
    </span> 


       
 

    



    <!-- Scripts -->
    <script src="{{url()}}{{ elixir('js/all.js')}} " ></script>  
    @include('paginas.home.home_vue_script')
    

   

  </body>

</html>