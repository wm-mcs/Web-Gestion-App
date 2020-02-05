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


     <div class="contiene-errores-general">

        <div class="sub-contiene-errores-general">
          <a href="{{route('get_home')}}"><img class="error-404-img-logo" src="{{url()}}/imagenes/Empresa/logo_rectangular.png"></a>
          <br>
          <div class="error-404-titulo">Ups! </div>
          <img class="error-404-img" src="{{url()}}/imagenes/Errores/desechufe.png">
          <div class="error-404-aclaracion">Nos confundimos :-( simplemente regresá dando <strong><a href="{{route('get_home')}}">click aquí</a></strong>  </div>
          
          
          <a href="{{route('get_home')}}" class="error-404-contiene-boton">            
            Volver al panel administrador
          </a>

          

        </div>
       
     </div>
  
  
 
   



      
  </body>

</html>