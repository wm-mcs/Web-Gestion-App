@extends('emails.layouts.layout_basico_para_mensajes')


@section('mensaje-texto')

{{$Texto}}
@endsection


@section('boton-llamada-accion-texto')

{{$Texto_boton}}
@endsection


@section('boton-llamada-accion-link')
{{$Link_del_boton}}

@endsection