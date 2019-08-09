@if($Entidad->estado != 'si')
 <div class="Entidades-listada-contenedor BackgroundGris">
@else
 <div class="Entidades-listada-contenedor">
@endif
   
    <img class="Entidades-listada-img" src="{{$Entidad->url_img}}">
  
        
    <div class="Entidad-listada-name"> {{$Entidad->name}}      </div>
    
     

     
        <a href="{{$Entidad->route_admin}}" >
           <div class="boton-simple-chico">
            <i class="fas fa-edit"></i> 
           </div>
        </a>
     
      
   
  
   
  
</div>