
<div class="formulario-label-fiel">
{!! Form::label('img', 'Logo', array('class' => 'formulario-label ')) !!}
{!! Form::file('img',['class' => 'formulario-field']) !!}   
</div>





@if(isset($Empresa))
<div class="admin-img-section-contenedor" >
  <div class="admin-img-section-text">Imagen actual de la empresa</div>
  <img class="admin-img-section-img" src="{{$Entidad->url_img}}"> 
</div>
@endif



 


 
 

 

