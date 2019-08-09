 @include('paginas.home.home_contacto')


 <section class="padding-xl" style="background-color:#30302f;">
       
          <div class="get_width_100 flex-row-center flex-justifice-space-around flex-wrap">
             <div class=" text-center contenedor-columna-footer Helper-OrdenarHijos-Row">
              <div class="get_width_100 flex-row-center flex-justifice-space-around">
                <img data-src="{{$Empresa->img_logo_cuadrado}}" class="logo-footer">
              </div>
              
            </div>

             {{-- parte de politicas --}}  
             <div class="text-center contenedor-columna-footer  Helper-OrdenarHijos-Row">
              <div class="get_width_100 flex-row-column">
                 <p class="color-text-gris espacio-letras small helper_cursor_pointer" data-toggle="modal" data-target="#modal-garantia">  
                    Política de devolución
                 </p>   

                  <p class="color-text-gris espacio-letras small helper_cursor_pointer" data-toggle="modal" data-target="#modal-mantenimiento">  
                    Política de mantenimiento
                 </p>            
              </div>


              <div class="get_width_100 flex-row-center flex-justifice-space-around flex-wrap">

                 @if($Empresa->facebook_empresa != 'no')
                  <a class="footer-icono-social" href="{{$Empresa->facebook_empresa}}"> 
                    <i class="fab fa-facebook-square"></i>
                  </a>
                 @endif 

                 @if($Empresa->instagram_empresa != 'no')
                  <a class="footer-icono-social" href="{{$Empresa->instagram_empresa}}"> 
                    <i class="fab fa-instagram"></i>
                  </a>
                 @endif 

                 @if($Empresa->twitter_empresa != 'no')
                  <a class="footer-icono-social" href="{{$Empresa->twitter_empresa}}"> 
                    <i class="fab fa-twitter-square"></i>
                  </a>
                 @endif 

                  @if($Empresa->linkedin_empresa != 'no')
                  <a class="footer-icono-social" href="{{$Empresa->linkedin_empresa}}"> 
                    <i class="fab fa-linkedin"></i>
                  </a>
                 @endif

                  @if($Empresa->youtube_empresa != 'no')
                  <a class="footer-icono-social" href="{{$Empresa->youtube_empresa}}"> 
                    <i class="fab fa-youtube"></i>
                  </a>
                 @endif

                  @if($Empresa->whatsapp_empresa != 'no')
                  <a class="footer-icono-social" href="{{$Empresa->link_whatsapp_send}}"> 
                    <i class="fab fa-whatsapp"></i>
                  </a>
                 @endif

                
                  <a class="footer-icono-social js-scroll-trigger" href="#contact"> 
                    <i class="fas fa-envelope"></i>
                  </a>
                 

              </div>  
            </div> 


            <div class="text-center contenedor-columna-footer  Helper-OrdenarHijos-Row">
              <div class="get_width_100 flex-row-column">

               @if($Empresa->telefono_empresa != 'no')
                 <p class="color-text-gris  get_width_100 espacio-letras-chico small">  
                  <span class="helper-aumenta-texto"><i class="fas fa-phone"></i></span> {{$Empresa->telefono_empresa}}
                 </p> 
               @endif

               @if($Empresa->celular_empresa != 'no')
                 <p class="color-text-gris  get_width_100 espacio-letras-chico small">  
                  <span class="helper-aumenta-texto"><i class="fas fa-mobile"></i></span> {{$Empresa->celular_empresa}}
                 </p> 
               @endif

               @if($Empresa->direccion_empresa != 'no')
                 <p class="color-text-gris  get_width_100 espacio-letras-chico small">  
                  <span class="helper-aumenta-texto"><i class="fas fa-map-marker-alt"></i></span> {{$Empresa->direccion_empresa}}
                 </p> 
               @endif

               @if($Empresa->horarios_empresa != 'no')
                 <p class="color-text-gris get_width_100  espacio-letras-chico  small">  
                  <span class="helper-aumenta-texto"><i class="fas fa-clock"></i></span> {{$Empresa->horarios_empresa}}
                 </p> 
               @endif

              
               
              </div>
            </div> 
                
          
          </div>
        
         
</section>


@include('paginas.home.home_modal_contacto')
@include('paginas.politicas.mantenimiento_garantia_modals')