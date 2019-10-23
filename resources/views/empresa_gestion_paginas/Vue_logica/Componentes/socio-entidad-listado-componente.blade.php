Vue.component('socio-entidad-listado' ,
{

props:['empresa','palabra_busqueda']
,  

data:function(){
    return {
         socios:this.empresa.socios_de_la_empresa

    }
}, 

watch:{ 

    palabra_busqueda: {
      immediate: true,
      deep: true,
      handler(newValue, oldValue) {
      	this.checkSearchStr(newValue);
      }
    }


   
},
methods:{
         
actualizar_socios:function(socios){
	this.socios = socios;
},
checkSearchStr: _.debounce(function(string){

	if(string != '')
	{
      alert(string);
	}
    }, 800)
},
created() {
    
    bus.$on('socios-set', (socios) => {
      this.socios = socios
    })
},
template:'

  <div v-if="socios.length > 0" class="listado-socios-contenedor-lista">

    <socio-list v-for="socio in socios" 
                 :key="socio.id" 
               :socio="socio" 
             :empresa="empresa"
              v-on:ActualizarSocios="actualizar_socios" ></socio-list>

  
  </div> 

'

}




);