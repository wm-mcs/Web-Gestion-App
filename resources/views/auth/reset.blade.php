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

  

     <div class="contiene_auth_form">
         <h1 class="auth_titulo_h1">Resetear contraseña  </h1>
          @include('formularios.auth.reset_password_get_form')
      </div>     
          
         
  
     

@stop