Vue.component('socio-entidad-listado' ,
{

props:['empresa','palabra_busqueda']
,  

data:function(){
    return {
         socios:'',
         cargando:false,
         cargando_inactivos:false,
         socios_inactivos:[]

    }
}, 

mounted: function mounted () {
  this.get_socios();
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

get_socios:function(){

  var url = '/get_socios_activos';

      var data = {  
                    empresa_id: this.empresa.id       
                 };  
      var vue = this;  
      this.cargando = true;         

     axios.post(url,data).then(function (response){  
            var data = response.data;  
            

            if(data.Validacion == true)
            {
               vue.cargando = false; 
               vue.socios = response.data.Socios;              
               
            }
            else
            {
              vue.cargando = false; 
              $.notify(response.data.Validacion_mensaje, "error");
            }
           
           }).catch(function (error){

                     
            
           });
  
},
get_socios_inactivos:function(){

  var url = '/get_socios_inactivos';

      var data = {  
                    empresa_id: this.empresa.id       
                 };  
      var vue = this;  
      this.cargando_inactivos = true;         

     axios.post(url,data).then(function (response){  
            var data = response.data;  
            

            if(data.Validacion == true)
            {
               vue.cargando_inactivos = false; 
               vue.socios_inactivos = response.data.Socios;    
               $.notify(response.data.Validacion_mensaje, "success");            
               
            }
            else
            {
              vue.cargando_inactivos = false; 
              $.notify(response.data.Validacion_mensaje, "error");
            }
           
           }).catch(function (error){

                     
            
           });
  
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
  <div class="titulo-socios-cuando-hay"><i class="fas fa-users"></i> Socios  <i class="far fa-hand-point-down"></i></div>

  <div v-if="socios.length > 0 && !cargando" class="listado-socios-contenedor-lista">

    <socio-list 

    v-for="socio in socios" 
                 :key="socio.id" 
               :socio="socio" 
             :empresa="empresa"
              v-on:ActualizarSocios="actualizar_socios" ></socio-list>

  
  </div> 
  <div v-else class="Procesando-text get_width_100">
     
                       <div class="cssload-container">
                             <div class="cssload-tube-tunnel"></div>
                       </div>
                  
    
  </div>
  <br>
  <br>

  <div v-if="socios_inactivos.length" class="titulo-socios-cuando-hay"><i class="fas fa-users"></i> Socios inactivos <i class="far fa-hand-point-down"></i></div>
  <div v-else class="simula_link get_width_100 text-center" v-on:click="get_socios_inactivos">
    Ver si hay socios inactivos
  </div>
   <div v-if=" !cargando_inactivos" class="listado-socios-contenedor-lista">

    <socio-list 

    v-for="socio in socios_inactivos" 
                 :key="socio.id" 
               :socio="socio" 
             :empresa="empresa"
              v-on:ActualizarSocios="actualizar_socios" ></socio-list>

  
  </div> 
  <div v-else class="Procesando-text get_width_100">
     
                       <div class="cssload-container">
                             <div class="cssload-tube-tunnel"></div>
                       </div>
                  
    
  </div>


</div>  
<div v-else class="cuando-no-hay-socios">
<div v-if="cargando" class="Procesando-text get_width_100">
     
                       <div class="cssload-container">
                             <div class="cssload-tube-tunnel"></div>
                       </div>
                  
    
  </div>
 <span v-else>No hay socios <i class="far fa-frown"></i></span> 
</div>

'

}




);