Vue.component('socio-entidad-listado' ,
{

props:['empresa','palabra_busqueda']
,  

data:function(){
    return {
         socios:this.empresa.socios_de_la_empresa,
         searchQuery:this.palabra_busqueda,
         searchQueryIsDirty: false,
         isCalculating: false

    }
}, 

watch:{ 

    searchQuery: function () {
      this.searchQueryIsDirty = true
      this.expensiveOperation()
    }
},
methods:{
         
actualizar_socios:function(socios){
	this.socios = socios;
},
expensiveOperation: _.debounce(function () {
      this.isCalculating = true
      setTimeout(function () {
        this.isCalculating = false
        this.searchQueryIsDirty = false
      }.bind(this), 1000)
    }, 500)
},
template:'

  <div v-if="socios.length > 0" class="listado-socios-contenedor-lista">

    <socio-list v-for="socio in socios" :key="socio.id" :socio="socio" :empresa="empresa"></socio-list>
  
  </div> 

'

}




);