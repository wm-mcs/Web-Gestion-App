<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EasySocio</title>
    <link rel="stylesheet" type="text/css" href="{{url()}}{{ elixir('css/admin.css') }}">
    <link rel="shortcut icon" href="{{ asset('imagenes/favicon.ico') }}">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <META name="robots" content="NOINDEX,NOFOLLOW">


{{--*/ $ImagenParaTaG         = url() . '/imagenes/EasySocio/easy-socio-el-software-para-administrar-gimnasios-academias-de-baile-institutos-de-ingles-y-mucho-más.jpg'/*--}}
{{--*/ $Titulo                = 'Bienvenido a una nueva forma de administrar tu emprendimiento' /*--}}
{{--*/ $DescriptionEtiqueta   = 'Si tienes un gimnsasio, una academia de baile, centro/escuela de danzas y quieres un sistema que te ayude a administrar tu negocio, estás en el lugar correcto porque te voy a contar de qué trata EasySocio' /*--}}
{{--*/ $PalabrasClaves        = '' /*--}}
{{--*/ $UrlDeLaPagina         = url() /*--}}


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

       <div v-if="menu_abierto" class="opasity-layer"></div>
       <div v-show="esResolucionDePc" class="column-wraper-cuando-esta-fixed"></div>
       <div v-show="mostrar_menu" class="admin-columna-contenedor">

       <div>

       </div>
         <div class="admin-columna-wraper">
           <div class="get_width_80 flex-row-column">


              <div v-show="esResolucionDeTablet" v-on:click="abrir_menu_cerrar_principal" class="miga-de-pan-boton-abrir-cerra-menu-texto"><i class="fas fa-times"></i></div>
                  @yield('columna')
              </div>



         </div>
       </div>



       <div :style="contenido_style_width" class="admin-contiene-content">
             @include('layouts.gestion_socios_layout.mensajes.mensajes')
              <div class="contiene-miga-y-auth">
                <div class="admin-contnedor-navegacion-miga">

                 <div v-if="esResolucionDeTablet" v-on:click="abrir_menu_cerrar_principal" class="miga-de-pan-boton-abrir-cerra-menu"><i class="fas fa-bars"></i></div>

                 @yield('miga-de-pan')
                </div>
                <div class="contiene-auth-y-sucursal">
                    <div class="navigation-auth-contenedor">


                     @if( Auth::user()->role >= 3)
                     <span v-show="!esResolucionDeTablet">
                      @yield('empresa-configuracion')
                     </span>
                     @endif
                     <span >
                     @yield('sucursal')
                     </span>

                     <nav-inicio></nav-inicio>
                    </div>

                </div>

              </div>

              <div class="contenedor-admin-entidad">
                <div class="get_width_100 Helper-OrdenarHijos-columna">
                    @yield('content')
                </div>
              </div>

      </div>
   </div>



        @include('layouts.JS_Partial.LogicaDeComoCargarJS')




  </body>

</html>
