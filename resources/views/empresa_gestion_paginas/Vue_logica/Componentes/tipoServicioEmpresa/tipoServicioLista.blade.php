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


        app.cargando = true;

        var data = {   servicio:this.servicio,
                     empresa_id:this.empresa.id
                       
                   }; 

              axios.post(url,data).then(function (response){  
              
              

              if(response.data.Validacion == true)
              {
                 app.cargando = false;
                 vue.empresa  = response.data.empresa;
                 $.notify(response.data.Validacion_mensaje, "success");
                 
              }
              else
              {
                app.cargando = false;
                $.notify(response.data.Validacion_mensaje, "error");
              }
             
             }).catch(function (error){

                       
              
             });   

     }

      
},
computed:{
  

},
template:`  
<div  class="empresa-gestion-listado-contenedor flex-justifice-space-between border-bottom-claro">
                 
                <div class="get_width_100 flex-wrap flex-row-center">
                 <div class="get_width_100 formulario-label-fiel-sin-width">
                   <label class="formulario-label">Nombre</label>
                   <input type="text" class="form-control" v-model="servicio.name">
                 </div> 
                 <div class="get_width_40 formulario-label-fiel-sin-width">
                   <label class="formulario-label">Tipo</label>
                   <select v-model="servicio.tipo" class="form-control">
                        
                        <option>clase</option>
                        <option>mensual</option>
                        
                    </select>
                 </div>
                 <div v-if="servicio.es_clase" class="get_width_30 formulario-label-fiel-sin-width">
                   <label class="formulario-label">Cantidad</label>
                   <input type="number" class="form-control" v-model="servicio.cantidad_clases" step="any">
                 </div>
                 <div class="get_width_30 formulario-label-fiel-sin-width">
                   <label class="formulario-label">Valor</label>
                   <input type="text" class="form-control" v-model="servicio.valor" step="any">
                 </div>
                 <div class="get_width_30 formulario-label-fiel-sin-width">
                   <label class="formulario-label">Moneda</label>
                   <select v-model="servicio.moneda" class="form-control">
                        
                        <option>$</option>
                        <option>U$S</option>
                        
                    </select>
                 </div>


                  <div class="get_width_100 flex-row-center flex-justifice-space-around formulario-label-fiel-sin-width">
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