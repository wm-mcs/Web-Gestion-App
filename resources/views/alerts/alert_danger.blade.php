@if(Session::has('alert-rojo'))
            <div class="Errores-Contenedor">
              
              <div class="Error-Titulo">
                <div style="padding: 12px;"><span class="icon-new_releases"></span> {{ Session::get('alert-rojo') }}</div> 
              
              </div>
              <div class="Error-iconoCerrar">
                <i class="fas fa-times"></i>
              </div>
            </div>
@endif 