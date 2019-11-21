var bus_empresas = new Vue();

Vue.component('mostrar-empresas' ,
{




data:function(){
    return {
       Empresas:{!! json_encode($Empresas) !!}

    }
}, 


methods:{
},
created() {
    
    bus_empresas.$on('empresas-set', (empresas) => {
      this.Empresas = empresas
    })
},
template:'


 

   <div class="admin-entidad-contenedor-entidades">
      <empresa-lista v-for="Empresa in  Empresas" :empresa="Empresa"> </empresa-lista>
   </div>
  
 

'

}




);