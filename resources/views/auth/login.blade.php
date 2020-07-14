@extends('layouts.user_layout.user_layout')


@section('title')
 Iniciar Sesión 
@stop

@section('MetaContent')
  Entra en.  
@stop

@section('MetaRobot')
 INDEX,FOLLOW
@stop




@section('content') 
<div class="container">
	<div class="row justify-content-center py-2 py-lg-5">
		<img class="col-11 col-lg-6 img-fluid p-2 p-lg-5 mb-3" src="{{url()}}/imagenes/Empresa/logo_rectangular.png">
		<div class="col-12 col-lg-7">  
         <h1 class="sub-titulos-class font-secondary text-color-black text-center mb-4">Inicio de sesión</h1>      
         @include('formularios.auth.login_form')
      </div>
	</div>
	
</div>
      
      
@stop