{!! Form::model(Request::all(),['route'   => 'get_admin_users', 
                'method'  => 'GET',
                'class'   => 'navbar-form',
                'role'    => 'search' ])                             !!}
  <div class="admin-entidad-buscador-contenedor">
  {!! Form::text('name', null , ['class'       => 'form-control', 
                                 'placeholder' => 'buscar'])        !!}
  {!! Form::select('role',config('options.role') , 
                                 null, ['class' => 'form-control']) !!}

  <button type="submit" class="btn btn-default">Buscar</button>
  </div>
  

{!! Form::close() !!}