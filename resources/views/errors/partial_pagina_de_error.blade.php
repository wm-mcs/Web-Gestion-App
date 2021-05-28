<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Upssss</title>
    @include('layouts.user_layout.css_fonts')
    <link rel="shortcut icon" href="{{ asset('imagenes/favicon.ico') }}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <META name="robots" content="NOINDEX,NOFOLLOW">
  </head>
  <body>
    <div class="w-100 d-flex flex-row align-items-center justify-content-center" style="height: 100vh;">

         <div class="p-5 d-flex flex-column align-items-center w-75">
          <div class="col-11 col-lg-5 d-flex flex-column align-items-center mb-5">
            <a class="" href="

            @if(Session::has('empresa_auth_public'))
            {{ Session::get('empresa_auth_public')->route_reservas }}
            @else
            {{route('get_home')}}
            @endif


           ">
             <img class="img-fluid" src="{{url()}}/imagenes/Empresa/logo_rectangular.png">
            </a>
          </div>

          <div class="color-text-gris titulos-class text-center mb-0">Ups!!! </div>
          <div class="col-11 col-lg-6 d-flex flex-column align-items-center mb-0" >
            <img class="img-fluid" src="{{url()}}/imagenes/Errores/desechufe.png">
          </div>
          <div class="color-text-gris parrafo-class text-center mb-5">Nos confundimos. Regresá dando <strong><a href="
            @if(Session::has('empresa_auth_public'))
            {{ Session::get('empresa_auth_public')->route_reservas }}
            @else
            {{route('get_home')}}
            @endif">click aquí</a></strong>
           </div>

           <div class="col-12 col-lg-8">
              <a  href="
            @if(Session::has('empresa_auth_public'))
            {{ Session::get('empresa_auth_public')->route_reservas }}
            @else
            {{route('get_home')}}
            @endif " class="Boton-Fuente-Chica Boton-Primario-Relleno">
                Volver <i class="fas fa-angle-double-right"></i>
              </a>
           </div>

        </div>

    </div>
  </body>
</html>
