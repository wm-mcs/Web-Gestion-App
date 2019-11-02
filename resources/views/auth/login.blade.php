@extends('layouts.user_layout.user_layout')


@section('title')
 Iniciar Sesion 
@stop

@section('MetaContent')
  Entra en.  
@stop

@section('MetaRobot')
 INDEX,FOLLOW
@stop




@section('content')


 
      <img class="auth-logo-easy" src="{{url()}}/imagenes/Empresa/logo rectangular.png">

      <div class="contiene_auth_form">

         <h1 class="auth_titulo_h1">Inicio de sesión</h1>
         @include('formularios.auth.login_form')
      </div>

     
  
     

@stop