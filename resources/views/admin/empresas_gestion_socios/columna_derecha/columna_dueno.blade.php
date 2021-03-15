

{!! Form::open(['route'  => 'get_analiticas',
                  'method' => 'Post',
                  'class'  => 'w-100 my-2 p-3'])                         !!}


  <input type="hidden" name="empresa_id" value="{{$Empresa->id}}">

  <div class="Boton-Primario-Sin-Relleno disparar-este-form">
    <i class="fas fa-external-link-alt"></i>Analíticas
  </div>



  {!! Form::close() !!}




  <a href="{{route('getIndex',['empresa_id' => $Empresa->id ])}}" class="Boton-Primario-Sin-Relleno ">
     Agenda
  </a>
