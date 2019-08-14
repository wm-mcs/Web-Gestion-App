<div class="admin-columna-contenedor">

 {{-- imagen logo --}}
 <a href="{{route('get_home')}}"><img class="admin-header-logo" src="{{$Empresa_gestion->url_img}}"></a>

 <ul>
   @if(Auth::user()->role == '10')
   <div id="admin-col-superadmin">


        
        
    </div>
   @endif

   <div id="admin-col-admin">
              
        
   </div>

</ul>

   

    
</div>