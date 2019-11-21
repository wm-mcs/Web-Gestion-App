Vue.component('mostrar-empresas' ,
{




data:function(){
    return {
       Empresas:{!! json_encode($Empresas) !!}

    }
}, 


methods:{
},
template:'


 

   <div class="admin-entidad-contenedor-entidades">
      <empresa-lista v-for="Empresa in  Empresas" :empresa="Empresa"> </empresa-lista>
   </div>
  
 

'

}




);