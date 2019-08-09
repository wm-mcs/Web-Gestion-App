





<div class="row" id="footer">

   <!-- primer row (el de los links de contacto y síguenos)-->
   <div class="col-xs-12 space-bottom">
   <div class="row">


      <!-- columna del isologo -->
      <div class="col-md-4 footer-line hidden-xs hidden-sm" style="text-align:right;"><div class="column-container">
        <div class="isologo_container">
          <div class="isologo">
          </div>
        </div>
      </div></div>


      <!-- columna de datos de contácto -->
      <div class="col-md-4 footer-line"><div class="column-container">

        <h5 class="footer-title">contáctanos</h5>

       @if($Empresa->telefono != null) 
        <h5><span class="glyphicon glyphicon-earphone"></span> {{$Empresa->telefono}}</h5>
      @endif

          @if($Empresa->celular != null)
        <h5><span class="glyphicon glyphicon-phone""></span> {{$Empresa->celular}}</h5>
       @endif 

       @if($Empresa->email != null)
        <h5><span class="glyphicon glyphicon-envelope"></span> {{$Empresa->email}}</h5>
       @endif

       
       @if($Empresa->direccion != null) 
        <h5><span class="glyphicon glyphicon-map-marker"></span> {{$Empresa->direccion}}</h5>
       @endif

       @if($Empresa->horarios_dias != null) 
        <h5><span class="glyphicon glyphicon-time"></span> {{$Empresa->horarios_dias}}</h5>
       @endif

      </div></div>

  
      <!-- columna de datos de redes sociales y mailing letters -->
      <div class="col-md-4"><div class="column-container">

        <h5 class="footer-title">síguenos</h5>

        <a href="https://www.facebook.com/GLOBALTARGET/" target="_blank" alt="Global Target social media"><h5><span class="socicon socicon-facebook"></span> /globaltarget</h5></a>
        <a href="https://www.instagram.com/agencia_globaltarget/" target="_blank" alt="Global Target social media"><h5><span class="socicon socicon-instagram"></span> /agencia_globaltarget</h5> </a>
        <a href="https://www.linkedin.com/company/agencia-global-target" target="_blank" alt="Global Target social media"><h5><span class="socicon socicon-linkedin"></span> /agencia-global-target</h5></a>
      </div></div>


  </div>
  </div>


  <!-- primer row (el de los links de contacto y síguenos)-->
  <div class="col-xs-12">
  <div class="row">


      <div class="col-md-6 footer-line2" style="text-align:right;">
        <h5 class="logo-font kerning"><strong>GLOBALTARGET&#x24B8;2017</strong></h5>
      </div>

      <div class="col-md-6">
        <h5>Diseño de interfaz y desarrollo web: <a>Simbionte</a></h5>
      </div>

  </div>
  </div>

</div>
        




