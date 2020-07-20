<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Upssss</title>
    <link rel="stylesheet" type="text/css" href="{{url()}}{{ elixir('css/admin.css') }}">  
    <link rel="shortcut icon" href="{{ asset('imagenes/favicon.ico') }}"> 
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">     
    <META name="robots" content="NOINDEX,NOFOLLOW">
  </head>
  <body>  
    <div class="w-100 " style="min-height: 100vh;">
      <div class="d-flex flex-column align-items-center justify-content-center" style="height: 100%;">
         <div class="d-flex flex-column align-items-center col-11 col-lg-7">
          <div class="col-10 col-lg-6 mb-5">
            <a class="" href="{{route('get_home')}}">
             <img class="img-fluid" src="{{url()}}/imagenes/Empresa/logo_rectangular.png">
            </a>  
          </div>
                  
          <div class="color-text-gris titulos-class text-center mb-0">Ups! </div>
          <div class="col-10 col-lg-6 mb-0" >
            <img class="img-fluid" src="{{url()}}/imagenes/Errores/desechufe.png">
          </div>          
          <div class="color-text-gris parrafo-class text-center mb-5">Nos confundimos. Regresá dando <strong><a href="{{route('get_home')}}">click aquí</a></strong> 
           </div>  
          <a  href="{{route('get_home')}}" class="Boton-Fuente-Chica Boton-Primario-Relleno">            
            Volver al panel administrador <i class="fas fa-angle-double-right"></i>
          </a>    
        </div>
      </div>       
     </div>      
  </body>
</html>