<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Administrador Panel</title>
    <link rel="stylesheet" type="text/css" href="{{url()}}{{ elixir('css/admin.css') }}">  

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous"> 
    
    <META name="robots" content="NOINDEX,NOFOLLOW">
  </head>

  <body>
  
  
  <div class="admin-content-background-color"></div>
   
   <div id="app" class="admin-contiene-columna-y-content">
      @include('layouts.gestion_socios_layout.columna_derecha.columna')
      <div class="get_width_20"></div>
      <div class="admin-contiene-content">
        
          <div class="admin-contiene-content-wraper"> 
            
         
               @include('alerts.Alertas_Todos_Agrupados.alertas_agrupados')  
               <div class="admin-contnedor-navegacion-miga">
                {{-- home --}}
                <a href="{{route('get_admin_home')}}"><i class="fas fa-home"></i></a>
                {{-- separador --}}
                <span class="spam-separador">|</span> 
                {{-- lugar donde esta --}}
                @yield('miga-de-pan')                
              </div>
              <div class="contenedor-admin-entidad">
                <div class="get_width_100 Helper-OrdenarHijos-columna"> 
               @yield('content')
                </div>
              </div>
           </div>
      </div>      
   </div>

   
  

      <!-- Scripts -->
     <script src="{{url()}}{{ elixir('js/admin.js')}} " ></script>  

        @if(Auth::guest())
             <script  src="https://unpkg.com/vue@2.5.17/dist/vue.min.js"></script> 
        @else
            @if(Auth::user()->role ==='adminMcos522')
             <script  src="https://unpkg.com/vue@2.5.17/dist/vue.js"></script> 
            @else
             <script  src="https://unpkg.com/vue@2.5.17/dist/vue.min.js"></script> 
            @endif
        @endif
        <script  src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script> 
        {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/vue-select/2.6.2/vue-select.js"></script> --}}
        <script  src="https://unpkg.com/lodash@4.13.1/lodash.min.js"></script>



        
        @yield('vue-logica')   


      
  </body>

</html>