

  {{-- imagen logo --}}

  @if(isset($Empresa) )

  {!! Form::open(['route' => ['get_empresa_panel_de_gestion'],
                            'method'=> 'Post',
                            'files' =>  true,
                            'name'  => 'form1',
                            'class'=> 'w-100 d-flex flex-column align-items-center'
                          ])               !!}
                 <input type="hidden" name="empresa_id" value="{{$Empresa->id}}">

                  @if(file_exists($Empresa->path_url_img))
                  <span class="simula_link  disparar-este-form" >

                    <img class="logo-easy-columna mb-0" src="{{$Empresa->url_img}}">
                   </span>

                   <div class="text-center color-text-gris mb-5" style="font-size: 12px;">

                     <small>Powered by <b class="text-primary">Easysocio</b></small>
                   </div>

                 @else
                 <div class="admin-logo-contendor simula_link  disparar-este-form ">

                    <img class="logo-easy-columna" src="{{url()}}/imagenes/Empresa/logo_rectangular.png">

                </div>
                 @endif


  {!! Form::close() !!}



  @else
  <div class="admin-logo-contendor">
  	<a href="{{route('get_home')}}">
      <img class="logo-easy-columna" src="{{url()}}/imagenes/Empresa/logo_rectangular.png">
    </a>
  </div>

  @endif
