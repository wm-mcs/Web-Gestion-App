<nav class="navbar navbar-expand-lg navbar-light fixed-top " id="mainNav">
  <div class="container">
    <a class="navbar-brand js-scroll-trigger" href="{{route('get_home')}}"><img style="height:35px; " alt="{{$Empresa->name}}" src="{{$Empresa->img_logo_cuadrado}}"></a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">


      <ul class="navbar-nav ml-auto"> 

        <li class="nav-item">
          <a class="nav-link js-scroll-trigger" href="#contact">CONTACTO</a>
        </li>           
        @include('paginas.home.home_nav_auth')
      </ul>
    </div>
  </div>
</nav>













