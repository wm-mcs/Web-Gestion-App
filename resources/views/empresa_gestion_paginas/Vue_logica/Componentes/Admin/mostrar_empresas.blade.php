Vue.component('mostrar-empresas' ,
{


,  

data:function(){
    return {
       Empresas:{!! json_encode($Empresas) !!};

    }
}, 


methods:{
},
template:'


 <div class="contenedor-admin-entidad-titulo-form-busqueda">
    <div class="admin-entidad-titulo"> 
     <a href="{{route('get_admin_empresas_gestion_socios_crear')}}">
      <span class="admin-user-boton-Crear">Crear </span>
     </a>  
    </div>
    @include('admin.empresas_gestion_socios.partes.buscador')
 </div>
 <div class="admin-contiene-entidades-y-pagination">
   <div class="admin-entidad-contenedor-entidades">
      <empresa-lista v-for="Empresa in  Empresas" :empresa="Empresa"> </empresa-lista>
   </div>
   <div>
    
   </div>
 </div>

'

}




);