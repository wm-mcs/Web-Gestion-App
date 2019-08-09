@extends('layouts.creative.layout_creative')

@section('titulo') {{$Empresa->name}} @stop

@section('descripcion') {{$Empresa->descripcion_empresa}} @stop

@section('robot') index, follow @stop

@section('palabras_claves') {{$Empresa->palabras_claves_empresa}} @stop



@section('nav') @include('paginas.home.home_nav') @stop

@section('slider')  @include('paginas.home.slider') @stop

@section('contenido')
      @include('paginas.home.home_about') 
      @include('paginas.home.home_tener_pagina_web')
    
      @include('paginas.home.home_pasos_para_concretar')  
      @include('paginas.home.home_precios')
      @include('paginas.home.home_garantia')
@stop      









