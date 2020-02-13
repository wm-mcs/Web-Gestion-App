
Vue.component('tipo-de-servicios-modal',
{
props:['empresa'],

data:function(){
    return { 
      crear_service_name:'',
      crear_service_tipo:'',
      valor:'',
      moneda:'$',
      cantidad_clases:0

      }
},
mounted: function mounted () {        

    
     


},
computed: {
 listaDeServicios:function(){
    return this.empresa.tipo_servicios.sort();
 },
 tipo_clase:function(){
   if(this.crear_service_tipo == 'clase')
   {
    return true;
   }
   else
   {
    return false
   }
 }

},
methods:{
     valores_a_cero:function(){
      this.crear_service_name = '';
      this.crear_service_tipo = '';
                  this.moneda = '$';
                   this.valor = '';
         this.cantidad_clases = 0; 
     },
    

     agregarServicioShoww:function(){

       

       $('#modal-agregar-servicio').appendTo("body").modal('show');
     },
     agregarServicioCreat:function(){

       var url = '/set_nuevo_servicio';

       var vue = this;

       var data = {    name:this.crear_service_name,
                       tipo:this.crear_service_tipo ,
                 empresa_id:this.empresa.id,
                     moneda:this.moneda,
                      valor:this.valor,
            cantidad_clases:this.cantidad_clases   
                   }; 

      app.cargando = true;

              axios.post(url,data).then(function (response){  
              
               

              if(response.data.Validacion == true)
              {
                 app.cargando = false;
                 app.empresa = response.data.empresa;
                 $.notify(response.data.Validacion_mensaje, "success");
                 vue.valores_a_cero();
                 
              }
              else
              {
                app.cargando = false;
                $.notify(response.data.Validacion_mensaje, "error");
              }
             
             }).catch(function (error){

                       
              
             });      

     },
     deletServicio:function(servicio)
     {

        var result = confirm("¿Seguro que quieres hacer esto?");

        if(result){            
        
        var url = '/delet_servicio';

        var vue = this;

        var data = {   id:servicio.id,
               empresa_id:this.empresa.id
                       
                   }; 

        app.cargando = true;

              axios.post(url,data).then(function (response){  
              
              

              if(response.data.Validacion == true)
              {  app.cargando = false;
                 vue.empresa = response.data.empresa;
                 
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
     editarServicio:function(servicio){

        var url = '/editar_servicio';

        var vue = this;


        app.cargando = true;

        var data = {   servicio:servicio,
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
template:'
<span>
 <div id="boton-editar-socio" style="position:relative;" class="admin-user-boton-Crear"  v-on:click="agregarServicioShoww" title="Listado de servicios">
        <i class="far fa-list-alt"></i>  
       
 </div>

    <div class="modal fade" id="modal-agregar-servicio" tabindex="+1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <div class="">
              <h4 class="modal-title" id="myModalLabel"> Servicios</h4>
              <div class="modal-mensaje-aclarador">
                Existen dos tipos de servicios: periódicos (mensual, semestral y anual) y por clase (cuponeras)


              </div>
          </div>
          
          <button v-on:click="valores_a_cero" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fas fa-times"></i></span></button>
          
        </div>
        <div class="modal-body text-center"> 


             <div v-if="empresa.tipo_servicios.length > 0">
               <div v-for="servicio in empresa.tipo_servicios" class="empresa-gestion-listado-contenedor flex-justifice-space-between border-bottom-claro">
                 
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
                      <div v-if="$root.cargando" class="Procesando-text">
                       <div class="cssload-container">
                             <div class="cssload-tube-tunnel"></div>
                       </div>
                      </div>
                      <div v-else v-on:click="editarServicio(servicio)" title="Editar este servicio" class="boton-simple-chico">
                        <i class="fas fa-edit"></i> Editar @{{servicio.name}}
                     </div>    
                   </div>
                </div>
                
                 
                  
                 
               </div>

             </div>
             <div v-else>
               Aún no hay servicios creados. ¡Crea uno ahora!
             </div>


                  <div class="titulo-dentro-de-form" >
                     Crear nuevo <i class="fas fa-arrow-circle-down"></i>
                  </div>

                  <div class="form-group">
                      <label class="formulario-label" for="Nombre">Nombre del servicio  </label>
                      <input type="text" class="form-control"  v-model="crear_service_name" placeholder="Nombre del servicio" required  />
                  </div> 
                 

                 <div class="form-group">
                      <label class="formulario-label" for="Nombre">Tipo <span class="formulario-label-aclaracion">¿por clase o mensual?</span></label>
                     <select v-model="crear_service_tipo" class="form-control">
                        
                        <option>clase</option>
                        <option>mensual</option>
                        
                      </select>
                  </div>   
                  <div v-if="tipo_clase" class="get_width_50 formulario-label-fiel-sin-width">
                   <label class="formulario-label">Cantidad de clases</label>
                   <input type="number" class="form-control" v-model="cantidad_clases" step="any">
                 </div>

                  <div class="get_width_50 formulario-label-fiel-sin-width">
                   <label class="formulario-label">¿Cuánto cuesta?</label>
                   <input type="text" class="form-control" v-model="valor" step="any">
                 </div>
                 <div class="get_width_50 formulario-label-fiel-sin-width">
                   <label class="formulario-label">¿Pesos o Dolares?</label>
                   <select v-model="moneda" class="form-control">
                        
                        <option>$</option>
                        <option>U$S</option>
                        
                    </select>
                 </div>



               
                  
                  <div v-if="$root.cargando" class="Procesando-text">
                       <div class="cssload-container">
                             <div class="cssload-tube-tunnel"></div>
                       </div>
                  </div>
                  <div v-else v-on:click="agregarServicioCreat" class="boton-simple">@{{$root.boton_aceptar_texto}}</div>
                  
                 
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" v-on:click="valores_a_cero">@{{$root.boton_cancelar_texto}}</button>        
        </div>
      </div>
    </div> 
  </div>

</span>',

});