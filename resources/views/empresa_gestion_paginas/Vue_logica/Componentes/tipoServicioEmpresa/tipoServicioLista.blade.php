var tipoServicioLista = {
  

props:['servicio_prop'],

data:function(){
    return {
      cargando:false,
      servicio:'',
      array_cantidad_de_dias:cantidadDeDiasArray 
    }
}, 

mounted: function mounted (){  
  this.servicio = this.servicio_prop;
},
created(){   
    
},
methods:{

     editarServicio:function(){

        var url = '/editar_servicio';

        var vue = this;

        this.cargando = true;

        var data = {   servicio:this.servicio,
                     empresa_id:this.$root.empresa.id
                       
                   }; 

              axios.post(url,data).then(function (response){  

                if(response.data.Validacion == true)
                {
                  vue.cargando = false;
                  vue.empresa  = response.data.empresa;
                  $.notify(response.data.Validacion_mensaje, "success");                 
                }
                else
                {
                  vue.cargando = false;
                  $.notify(response.data.Validacion_mensaje, "error");
                }
             
             }).catch(function (error){
                vue.cargando = false;
                $.notify(error, "error");
             });   
     }      
},
computed:{ 

},
template:`  
<div  class="col-12 mb-1 p-2 p-lg-4 borde-bottom-gris mb-4 background-hover-gris-0">
  <div class="row">
    <div class="col-12 col-lg-6 formulario-label-fiel">
      <label class="formulario-label ">Nombre</label>
      <input type="text" class="formulario-field" v-model="servicio.name">
    </div> 
    <div class="col-12 col-lg-6 formulario-label-fiel">
      <label class="formulario-label">Tipo</label>
      <select v-model="servicio.tipo" class="formulario-field">                        
        <option>clase</option>
        <option>mensual</option>                        
      </select>
    </div>
    <div v-if="servicio.es_clase" class="col-12 col-lg-4 formulario-label-fiel">
      <label class="formulario-label">Cantidad</label>
      <input type="number" class="formulario-field" v-model="servicio.cantidad_clases" step="any">
    </div>
    <div class="col-12 col-lg-4 formulario-label-fiel">
      <label class="formulario-label">Valor</label>
      <input type="text" class="formulario-field" v-model="servicio.valor" step="any">
    </div>
    <div v-if="$root.aceptaDolares" class="col-12 col-lg-4 formulario-label-fiel">
      <label class="formulario-label">Moneda</label>
      <select v-model="servicio.moneda" class="formulario-field">                        
            <option>$</option>
            <option>U$S</option>                        
        </select>
    </div>
    <div class="col-12 col-lg-4 formulario-label-fiel">
      <label class="formulario-label">Se renueva cada</label>
      <select v-model="servicio.renovacion_cantidad_en_dias" class="formulario-field">         
        <option v-for="cantidad_dias in array_cantidad_de_dias" :value="cantidad_dias.cantidad_de_dias_numero">
          @{{cantidad_dias.cantidad_de_dias_texto}}
        </option>                                
      </select>
    </div>

    
    <div class="col-12 d-flex flex-column align-items-center">
          <div v-if="cargando" class="Procesando-text">
            <div class="cssload-container">
              <div class="cssload-tube-tunnel"></div>
            </div>
          </div>
          <div v-else v-on:click="editarServicio" title="Editar este servicio" class="w-100 mt-4 boton-simple-chico">
            <i class="fas fa-edit"></i> Editar @{{servicio.name}}
          </div>    
    </div>
  </div>
</div>


`




}; 