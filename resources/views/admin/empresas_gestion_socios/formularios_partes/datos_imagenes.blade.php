
<div class="formulario-label-fiel">
{!! Form::label('img', 'Logo', array('class' => 'formulario-label ')) !!}
{!! Form::file('img',['class' => 'formulario-field']) !!}   
</div>





@if(isset($Entidad))
<div class="flex-row-column get_width_100" >
  <img class="admin-img-section-img" src="{{$Entidad->url_img}}"> 
</div>
@endif



 


 
 

 

