@extends('layouts.user_layout.user_layout')


@section('title')
 Recuperar Contraseña  
@stop

@section('MetaContent')
  Recuperar Contraseña .  
@stop

@section('MetaRobot')
 NOINDEX,FOLLOW
@stop




@section('content')

  <img class="auth-logo-easy" src="{{url()}}/imagenes/Empresa/logo_rectangular.png">

     <div class="contiene_auth_form">
         <h1 class="auth_titulo_h1">Cambiar constraseña  </h1>
          @include('formularios.auth.reset_password_get_form')
      </div>     
          
         
  
     

@stop