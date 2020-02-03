Vue.component('socio-entidad-listado' ,
{

props:['empresa','palabra_busqueda']
,  

data:function(){
    return {
         socios:'',
         cargando:false

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

  <div v-if="socios.length > 0 || !cargando" class="listado-socios-contenedor-lista">

    <socio-list 

    v-for="socio in socios" 
                 :key="socio.id" 
               :socio="socio" 
             :empresa="empresa"
              v-on:ActualizarSocios="actualizar_socios" ></socio-list>

  
  </div> 
  <div v-else class="Procesando-text">
     
                       <div class="cssload-container">
                             <div class="cssload-tube-tunnel"></div>
                       </div>
                  
    
  </div>
</div>  
<div v-else class="cuando-no-hay-socios">
  No hay socios <i class="far fa-frown"></i>
</div>

'

}




);