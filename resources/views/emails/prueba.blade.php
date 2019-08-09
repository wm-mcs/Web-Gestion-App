@extends('emails.layouts.layout_principal')

@section('asunto_email')
 CONTRASEÑA
@stop

@section('texto_a_user_email')
 Ernesto, restablece tu contraseña
@stop

@section('mensaje_email')
 Parece que has olvidado tu contraseña y solicitado ayuda al respecto. Si es correcto, haz click en el siguiente botón para restablecerla.
@stop

@section('url_email')
 Restablecer
@stop


@section('boton_texto_email')
 Restablecer
@stop

@section('mensaje_secundario_email')
 Si has recibido este correo por error, no eres la persona a quien nos dirigimos o no has solicitado ayuda concerniente al olvido de tu contraseña; por favor elimina este correo.
@stop



