var tipoServicioLista = {
  

props:['servicio_prop'],

data:function(){
    return {
      cargando:false,
      servicio:'' 
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
<div  class="col-12 mb-1">
  <div class="row">
    <div class="col-6 formulario-label-fiel">
      <label class="formulario-label ">Nombre</label>
      <input type="text" class="formulario-field" v-model="servicio.name">
    </div> 
    <div class="col-6 formulario-label-fiel">
      <label class="formulario-label">Tipo</label>
      <select v-model="servicio.tipo" class="formulario-field">                        
        <option>clase</option>
        <option>mensual</option>                        
      </select>
    </div>
    <div v-if="servicio.es_clase" class="get_width_30 formulario-label-fiel">
      <label class="formulario-label">Cantidad</label>
      <input type="number" class="formulario-field" v-model="servicio.cantidad_clases" step="any">
    </div>
    <div class="get_width_30 formulario-label-fiel">
      <label class="formulario-label">Valor</label>
      <input type="text" class="formulario-field" v-model="servicio.valor" step="any">
    </div>
    <div class="get_width_30 formulario-label-fiel">
      <label class="formulario-label">Moneda</label>
      <select v-model="servicio.moneda" class="formulario-field">                        
            <option>$</option>
            <option>U$S</option>                        
        </select>
    </div>
    <div class="col-12 d-flex flex-column align-items-center">
          <div v-if="cargando" class="Procesando-text">
            <div class="cssload-container">
              <div class="cssload-tube-tunnel"></div>
            </div>
          </div>
          <div v-else v-on:click="editarServicio" title="Editar este servicio" class="boton-simple-chico">
            <i class="fas fa-edit"></i> Editar @{{servicio.name}}
          </div>    
    </div>
  </div>
</div>


`




}; 