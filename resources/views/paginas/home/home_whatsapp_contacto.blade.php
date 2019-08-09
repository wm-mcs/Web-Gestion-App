 @if($Empresa->whatsapp_empresa != 'no')


                <a class="contacto-whatsapp-contenedor" href="{{$Empresa->link_whatsapp_send}}">
                  <img data-src="{{ url() }}/imagenes/team/mauri1.jpg" class="contacto-whatsapp-img">
                  <div class="contacto-whatsapp-texto">
                    Escríbeme ahora mismo por Whatsapp 
                  </div>  

                  <span class="contacto-whatsapp-icono footer-icono-social" > 
                    <i class="fab fa-whatsapp"></i>
                  </span>
                </a>
                 
          @endif