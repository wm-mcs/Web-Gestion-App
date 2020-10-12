
<div class="formulario-label-fiel">
{!! Form::label('img', 'Logo', array('class' => 'formulario-label ')) !!}
{!! Form::file('img',['class' => 'formulario-field']) !!}   
</div>





@if(isset($Empresa))
<div class="admin-img-section-contenedor" >
  <div class="admin-img-section-text">Imagen actual de la empresa</div>

   @if(file_exists($Empresa->path_url_img))
     <img class="admin-img-section-img" src="{{$Empresa->url_img}}"> 
   @else
      <p class="color-text-gris">No hay logo</p>
   @endif
 
</div>
@endif



 


 
 

 

