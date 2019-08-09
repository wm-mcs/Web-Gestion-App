
<div class="formulario-label-fiel">
{!! Form::label('img', 'Portada', array('class' => 'formulario-label ')) !!}
{!! Form::file('img',['class' => 'formulario-field']) !!}   
</div>

<div class="formulario-label-fiel">
{!! Form::label('img2', 'Imagen Secundaria', array('class' => 'formulario-label ')) !!}
{!! Form::file('img2',['class' => 'formulario-field']) !!}   
</div> 

@if(isset($Entidad))
<div class="flex-row-column get_width_100" >
  <img class="admin-img-section-img" src="{{$Entidad->url_img_portada}}">
  <img class="admin-img-section-img" src="{{$Entidad->url_img_adicional}}">  
</div>
@endif








 


 
 

 

