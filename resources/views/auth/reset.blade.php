@extends('layouts.user_layout.user_layout')


@section('title')
 Resetear Contraseña  
@stop

@section('MetaContent')
  Resetear Contraseña .  
@stop

@section('MetaRobot')
 NOINDEX,FOLLOW
@stop




@section('content')

{{-- ejemplo para la bavehacion --}}
<div class="admin-contnedor-navegacion-miga">
  {{-- home --}}
  <a href="{{route('get_home')}}"><span class="icon-home"></span></a>

  {{-- separador --}}
  <span class="spam-separador"><span class="icon-keyboard_arrow_right"></span></span> 
    
  {{-- lugar donde esta --}}
  <span>Resetear Contraseña</span>
</div>

 <div class="container-fluid section-wrapper">
     <div class="row">    
      <div class="col-sm-8 col-sm-push-2 col-md-6 col-md-push-3 col-lg-4 col-lg-push-4 wow fadeInUp">          
          @include('formularios.auth.reset_password_get_form')
      </div>
     </div>  
 </div>          
          
         
  
     

@stop