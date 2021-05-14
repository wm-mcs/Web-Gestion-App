

@if(Auth::user()->role == '10')
<a href="{{$Empresa->route_reservas}}"> Panel reserva</a>
@endif
