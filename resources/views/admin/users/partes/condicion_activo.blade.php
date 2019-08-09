@if($user->estado === 'si')
 <div class="admin-lista-dato-secundario helper-Success"><span class="icon-check"></span> Activo</div> 
@else
 <div class="admin-lista-dato-secundario helper-danger"><span class="icon-cancel"></span> Desactivado</div>
@endif