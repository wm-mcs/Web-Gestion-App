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


 


      <div class="contiene_auth_form">
         <h1>Inicio de Sesión</h1>
         @include('formularios.auth.login_form')
      </div>

     
  
     

@stop