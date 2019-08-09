<div class="container-fluid section-wrapper-footer bgcolor-2" id="footer">
  <div class="row">
    <div class="col-md-10 col-md-push-1 col-lg-8 col-lg-push-2">





   <!-- primer row (el de los links de contacto y síguenos)-->
   <div class="container-fluid">
   <div class="row">

    <!-- columna del isologo -->
    <div class="col-md-4 footer-line hidden-xs hidden-sm footer-col-height" style="text-align:right;">
      <div class="footer-isologo-container footer-col-height">
        <img class="img-responsive footer-isologo" src="imagenes/Empresa/isologo_golden_bright_big.png">
      </div>
    </div>


    <!-- columna de datos de contácto -->
    <div class="col-md-4 footer-line footer-responsive-vertical-space footer-col-height">

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

    </div>

  
    <!-- columna de datos de redes sociales y mailing letters -->
    <div class="col-md-4 footer-line3 footer-responsive-vertical-space footer-col-height">

      <h5 class="footer-title">síguenos</h5>

      <a href="https://www.facebook.com/GLOBALTARGET/" target="_blank" alt="Global Target social media"><h5><span class="socicon socicon-facebook"></span> /globaltarget</h5></a>
      <a href="https://www.instagram.com/agencia_globaltarget/" target="_blank" alt="Global Target social media"><h5><span class="socicon socicon-instagram"></span> /agencia_globaltarget</h5> </a>
      <a href="https://www.linkedin.com/company/agencia-global-target" target="_blank" alt="Global Target social media"><h5><span class="socicon socicon-linkedin"></span> /agencia-global-target</h5></a>
    </div>


  </div>
 </div>




  <!-- segundo row (copyright y diseñado por)-->
  <div class="row footer-responsive-vertical-space footer-last-row">


      <div class="col-md-6 footer-line2" style="text-align:right;">
        <h5 class="logo-font kerning"><strong>GLOBALTARGET&#x24B8;2017</strong></h5>
      </div>

      <div class="col-md-6">
        <h5>Diseño de interfaz y desarrollo web: <a>Simbionte</a></h5>
      </div>

  </div>






    </div>
  </div>
</div>      




