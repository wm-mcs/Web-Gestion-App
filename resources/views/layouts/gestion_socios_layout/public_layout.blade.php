<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{$Data['title']}}</title>
    <link rel="stylesheet" type="text/css" href="{{url()}}{{ elixir('css/admin.css') }}">
    <link rel="shortcut icon" href="{{$Empresa->url_img}}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <META name="robots" content="NOINDEX,NOFOLLOW">

    {{--*/ $ImagenParaTaG         = $Data['img'] /*--}}
    {{--*/ $Titulo                = $Data['title'] /*--}}
    {{--*/ $DescriptionEtiqueta   = $Data['description'] /*--}}
    {{--*/ $PalabrasClaves        = '' /*--}}


    <meta property="og:type"               content="website" />
    <meta property="og:title"              content="{{ $Titulo}} " />
    <meta property="og:description"        content="{{$DescriptionEtiqueta}}" />
    <meta property="og:image"             content="{{$ImagenParaTaG }}" />
    <meta property="og:image:secure_url"  content="{{$ImagenParaTaG }}" />
    <meta property="og:image:width"  content="250">
    <meta property="og:image:height" content="250">



  </head>

  <body>
   <div id="app" class="admin-contiene-columna-y-content">
        <div v-if="cargando" class="cargando-style-contenedor">
            <div class="cargando-style-contenedor-sub">
                <div class="cssload-container">
                    <div class="cssload-tube-tunnel"></div>
                </div>
            </div>
        </div>
        <div class="w-100 d-flex flex-column align-items-center ">
            @yield('content')
        </div>
    </div>
    @include('layouts.JS_Partial.LogicaDeComoCargarJS')
  </body>

</html>
