Vue.component('socio-entidad-listado' ,
{

props:['empresa']
,  



methods:{
         

},
template:'<span>

  <div v-if="socios.length > 0" class="listado-socios-contenedor-lista">

    <socio-list  v-for="socio in empresa.socios_de_la_empresa" :key="socio.id" :socio="socio" :empresa="empresa"></socio-list>
  
  </div> 

</span>'

}




);