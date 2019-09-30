Vue.component('socio-entidad-listado' ,
{

props:['empresa','palabra_busqueda']
,  

data:function(){
    return {
         socios:this.empresa.socios_de_la_empresa,
         busqueda:this.palabra_busqueda

    }
}, 

watch:{ 

    busqueda: function (newVal) {

      this.checkSearchStr(newVal);
    }
},
methods:{
         
actualizar_socios:function(socios){
	this.socios = socios;
},
checkSearchStr: _.debounce(function(string) {
        alert(string);
    }, 100)
},
template:'

  <div v-if="socios.length > 0" class="listado-socios-contenedor-lista">

    <socio-list v-for="socio in socios" :key="socio.id" :socio="socio" :empresa="empresa"></socio-list>
  
  </div> 

'

}




);