{!! Form::model(Request::all(),['route'   => 'get_admin_noticias', 
                'method'  => 'GET',
                'class'   => 'navbar-form',
                'role'    => 'search' ])                             !!}
  <div class="admin-entidad-buscador-contenedor">
  {!! Form::text('name', null , ['class'       => 'form-control', 
                                 'placeholder' => 'buscar'])        !!}
 

  <button type="submit" class="btn btn-default">Buscar</button>
  </div>
  

{!! Form::close() !!}