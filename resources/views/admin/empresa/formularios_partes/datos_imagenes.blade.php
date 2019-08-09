
<div class="formulario-label-fiel">
{!! Form::label('logo_cuadrado', 'Logo Cuadrado', array('class' => 'formulario-label ')) !!}
{!! Form::file('logo_cuadrado',['class' => 'formulario-field']) !!}   
</div>

<div class="formulario-label-fiel">
{!! Form::label('logo_horizontal', 'Logo Horizontal', array('class' => 'formulario-label ')) !!}
{!! Form::file('logo_horizontal',['class' => 'formulario-field']) !!}   
</div>

<div class="formulario-label-fiel">
{!! Form::label('logo_vertical', 'Logo Vertical', array('class' => 'formulario-label ')) !!}
{!! Form::file('logo_vertical',['class' => 'formulario-field']) !!}   
</div>

@if($Empresa->logo_cuadrado != null)
 <div class="contiene-img-y-nombre">
   <div class="formulario-label">Logo Cuadrado </div>
   <img class="admin-empresa-img-corporativas" src="{{url()}}/imagenes/{{$Empresa->logo_cuadrado}}">
 </div>
@endif

@if($Empresa->logo_horizontal != null)
 <div class="contiene-img-y-nombre">
   <div class="formulario-label">Logo Horizontal </div>
   <img class="admin-empresa-img-corporativas" src="{{url()}}/imagenes/{{$Empresa->logo_horizontal}}">
 </div>
 
@endif

@if($Empresa->logo_horizontal != null)
 <div class="contiene-img-y-nombre">
   <div class="formulario-label">Logo Vertical </div>
   <img class="admin-empresa-img-corporativas" src="{{url()}}/imagenes/{{$Empresa->logo_horizontal}}">
 </div>
@endif



 


 
 

 

