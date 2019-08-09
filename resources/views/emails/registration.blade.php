@extends('emails.layouts.layout_principal')

@section('asunto_email')
 CONTRASEÑA
@stop

@section('texto_a_user_email')
 {{ $user->first_name}}, gracias por registrarte. 
@stop

@section('mensaje_email')
 Por favor <strong>confirma tu dirección de correo</strong> para completar el proceso de registro <a href="{{$url}}"> haciendo click aquí.</a>
@stop

@section('url_email')
 {{$url}}
@stop


@section('boton_texto_email')
 Confirmar cuenta
@stop

@section('mensaje_secundario_email')
 Si has recibido este correo por error, no eres la persona a quien nos dirigimos o no has solicitado registrar un usuario en nuestro sitio web; por favor elimina este correo.
@stop