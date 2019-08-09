

<!-- nos jode todos los breakpoints el coso ahi, no puede estar junto con los links de navegacion -->

<!--
@if(Auth::guest())
	<li id="icono-user-en-navbar" title="icono user"><a href=""><span class="glyphicon glyphicon-user"></span></a></li>
@else
 	<li class="icono-user-en-navbar-logeado" ><a  href="">{{Auth::user()->first_name}}</a></li>
@endif-->


<!-- nueva ubicacion del user-menu -->
@if(Auth::guest())
{{--   <li id="icono-user-en-navbar" title="icono user"><a href=""><span class="glyphicon glyphicon-user"></span></a></li> --}}
@else
   <li class="nav-item">
              <a class="nav-link " href="{{route('get_admin_home')}}">{{Auth::user()->first_name}}</a>
   </li>
@endif