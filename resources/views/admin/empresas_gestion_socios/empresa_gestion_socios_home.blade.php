@extends('layouts.gestion_socios_layout.admin_layout')


@section('miga-de-pan') 

  <span>Empresas Gestion</span>
@stop

@section('content')



 {{-- titulo --}}
 <div class="contenedor-admin-entidad-titulo-form-busqueda">
    <div class="admin-entidad-titulo"> 
     <a href="{{route('get_admin_empresas_gestion_socios_crear')}}">
      <span class="admin-user-boton-Crear">Crear </span>
     </a>  
    </div>
    @include('admin.empresas_gestion_socios.partes.buscador')
 </div>
 <div class="admin-contiene-entidades-y-pagination">
   <div class="admin-entidad-contenedor-entidades">
     @foreach($Empresas as $marca)
          @include('admin.empresas_gestion_socios.partes.lista')
     @endforeach
   </div>
   <div>
     {!! $Empresas->appends(Request::all())->render() !!}
   </div>
 </div>

 


  

  
@stop

@section('vue-logica')


<script type="text/javascript">


    

     
    



</script>

@stop



@section('columna')

  {{-- imagen logo --}}
  <a href="{{route('get_home')}}"><img class="admin-header-logo" src="{{$Empresa->url_img}}"></a>

  @include('admin.empresas_gestion_socios.columna_derecha.columna_operario')
  @include('admin.empresas_gestion_socios.columna_derecha.columna_dueño_empresa')
  @include('admin.empresas_gestion_socios.columna_derecha.columna_vendedor')
  @include('admin.empresas_gestion_socios.columna_derecha.columna_super_admin')
@stop