@extends('layouts.user_layout.user_layout')


@section('title')
 Resetear Contraseña  
@stop

@section('MetaContent')
  Resetear Contraseña   
@stop

@section('MetaRobot')
 NOINDEX,FOLLOW
@stop




@section('content')





<a href="{{route('get_home')}}">
 <img class="auth-logo-easy" src="{{url()}}/imagenes/Empresa/logo_rectangular.png">
</a>
<div class="contiene_auth_form">
 <h1 class="auth_titulo_h1">Recuperar contraseña  </h1>
  @include('formularios.auth.reset_password_form')
</div>

     

@stop