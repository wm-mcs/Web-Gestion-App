  {!! Form::open(['route'  => ['get_control_access_view'],
                  'method' => 'Post',
                  'class'  => 'w-100 my-2 p-3'])                         !!}   


  <input type="hidden" name="empresa_id" value="{{$Empresa->id}}">   

  <div class="Boton-Primario-Sin-Relleno disparar-este-form">
    <i class="fas fa-external-link-alt"></i> Iniciar control de accesso 
  </div>                 
                 
                    
 
  {!! Form::close() !!} 