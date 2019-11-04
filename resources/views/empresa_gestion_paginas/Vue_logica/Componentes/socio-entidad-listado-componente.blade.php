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
      
      var url = '/buscar_socios_activos';

      var data = {  busqueda: string,
                    empresa_id: this.empresa.id       
                 };  
      var vue = this;           

     axios.post(url,data).then(function (response){  
            var data = response.data;  
            

            if(data.Validacion == true)
            {
               vue.socios = response.data.Socios;              
               
            }
            else
            {
              $.notify(response.data.Validacion_mensaje, "error");
            }
           
           }).catch(function (error){

                     
            
           });



	}
    }, 800)
},
created() {
    
    bus.$on('socios-set', (socios) => {
      this.socios = socios
    })
},
template:'
<div v-if="socios.length" class="empresa-contendor-de-secciones">
  <div class="empresa-titulo-de-secciones"><i class="fas fa-users"></i> Socios </div>

  <div v-if="socios.length > 0" class="listado-socios-contenedor-lista">

    <socio-list v-for="socio in socios" 
                 :key="socio.id" 
               :socio="socio" 
             :empresa="empresa"
              v-on:ActualizarSocios="actualizar_socios" ></socio-list>

  
  </div> 
</div>  
<div v-else class="cuando-no-hay-socios">
  No hay socios <i class="far fa-frown"></i>
</div>

'

}




);