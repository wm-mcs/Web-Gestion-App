@if($user->role != 'user')
 <div class="admin-lista-dato-secundario Helper-Fuente-Bold"><span class="icon-check"></span> {{$user->role}}</div> 
@else
<div class="admin-lista-dato-secundario"><span class="icon-check"></span> {{$user->role}}</div> 
@endif