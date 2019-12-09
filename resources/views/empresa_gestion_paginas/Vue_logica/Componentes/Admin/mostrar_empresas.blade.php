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


 

   <div class="listado-socios-contenedor-lista">
      <empresa-lista v-for="Empresa in  Empresas" :empresa="Empresa" :key="Empresa.id"> </empresa-lista>
   </div>
  
  
 

'

}




);