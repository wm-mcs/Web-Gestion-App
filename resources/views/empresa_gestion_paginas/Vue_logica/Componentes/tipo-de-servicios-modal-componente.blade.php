
Vue.component('tipo-de-servicios-modal',
{
props:['empresa'],

data:function(){
    return { 
      crear_service_name:'',
      crear_service_tipo:''

      }
},
mounted: function mounted () {        

    
     


},
computed: {
  listaDeServicios:function(){
    return this.empresa.tipo_servicios.sort();
  }

},
methods:{

    

     agregarServicioShoww:function(){

       

       $('#modal-agregar-servicio').appendTo("body").modal('show');
     },
     agregarServicioCreat:function(){

       var url = '/set_nuevo_servicio';

       var vue = this;

       var data = {    name:this.crear_service_name,
                       tipo:this.crear_service_tipo ,
                 empresa_id:this.empresa.id
                   }; 

              axios.post(url,data).then(function (response){  
              
              

              if(response.data.Validacion == true)
              {
                 vue.empresa = response.data.empresa;
                 $.notify(response.data.Validacion_mensaje, "success");

                 vue.crear_service_name = '';
                 vue.crear_service_tipo = '';
              }
              else
              {
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

              axios.post(url,data).then(function (response){  
              
              

              if(response.data.Validacion == true)
              {
                 vue.empresa = response.data.empresa;
                 
                 $.notify(response.data.Validacion_mensaje, "warn");
                 
              }
              else
              {
                $.notify(response.data.Validacion_mensaje, "error");
              }
             
             }).catch(function (error){

                       
              
             });   
        }   
     },
     editarServicio:function(servicio){

        var url = '/editar_servicio';

        var vue = this;

        var data = {   servicio:servicio,
                     empresa_id:this.empresa.id
                       
                   }; 

              axios.post(url,data).then(function (response){  
              
              

              if(response.data.Validacion == true)
              {
                 vue.empresa = response.data.empresa;
                 $.notify(response.data.Validacion_mensaje, "warn");
                 
              }
              else
              {
                $.notify(response.data.Validacion_mensaje, "error");
              }
             
             }).catch(function (error){

                       
              
             });   

     }


         

},
template:'
<span>
 <div id="boton-editar-socio" style="position:relative;" class="admin-user-boton-Crear"  v-on:click="agregarServicioShoww" title="Listado de servicios">
        <i class="far fa-list-alt"></i>  <span class="" >Servicios</span> 
       
 </div>

    <div class="modal fade" id="modal-agregar-servicio" tabindex="+1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel"> Servicio</h4>
          <div class="modal-mensaje-aclarador">
            Aquí van los servicios que más frecuentemente tú vas a vender. Pueden ser por <strong>clase</strong>  (sería para el caso que vendes cuponeras de clases) o <strong>mensual</strong>  (ejemplo: un pase libre). En lo que se refiere a mensual es simplemente nuestra distinción, perfectamente puedes vender un pase libre e indicar que se vence en los meses que tu quieras.


          </div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fas fa-times"></i></span></button>
          
        </div>
        <div class="modal-body text-center"> 


             <div v-if="empresa.tipo_servicios.length > 0">
               <div v-for="servicio in empresa.tipo_servicios" class="empresa-gestion-listado-contenedor flex-justifice-space-between">
                 
                <div class="get_width_70 flex-wrap flex-row-center">
                 <div class="get_width_40 formulario-label-fiel-sin-width">
                   <label class="formulario-label">Nombre</label>
                   <input type="text" class="form-control" v-model="servicio.name">
                 </div> 
                 <div class="get_width_50 formulario-label-fiel-sin-width">
                   <label class="formulario-label">¿Por clase o mensual?</label>
                   <select v-model="servicio.tipo" class="form-control">
                        
                        <option>clase</option>
                        <option>mensual</option>
                        
                    </select>
                 </div>
                 <div class="get_width_50 formulario-label-fiel-sin-width">
                   <label class="formulario-label">¿Cuánto cuesta?</label>
                   <input type="text" class="form-control" v-model="servicio.valor" step="any">
                 </div>
                 <div class="get_width_50 formulario-label-fiel-sin-width">
                   <label class="formulario-label">¿Pesos o Dolares?</label>
                   <select v-model="servicio.moneda" class="form-control">
                        
                        <option>$</option>
                        <option>U$S</option>
                        
                    </select>
                 </div>
                </div>
                
                 <div>
                   <div class="get_width_20 flex-row-center flex-justifice-space-around">
                     <div v-on:click="deletServicio(servicio)" title="Eliminar esté servicio" class="boton-simple-chico">
                        <i class="fas fa-trash-alt"></i>
                     </div>
                      <div v-on:click="editarServicio(servicio)" title="Editar esté servicio" class="boton-simple-chico">
                        <i class="fas fa-edit"></i>
                     </div>    
                   </div>
                 </div>
               </div>

             </div>
             <div v-else>
               Aun no hay servicios creados. Crea uno ;) 
             </div>


                  <div class="titulo-dentro-de-form" >
                     Crear nuevo <i class="fas fa-arrow-circle-down"></i>
                  </div>

                  <div class="form-group">
                      <label class="formulario-label" for="Nombre">Nombres  </label>
                      <input type="text" class="form-control"  v-model="crear_service_name" placeholder="Nombre" required  />
                  </div> 
                 

                 <div class="form-group">
                      <label class="formulario-label" for="Nombre">Tipo <span class="formulario-label-aclaracion">¿por clase o mensual?</span></label>
                     <select v-model="crear_service_tipo" class="form-control">
                        
                        <option>clase</option>
                        <option>mensual</option>
                        
                      </select>
                  </div>   



               

                  <div v-on:click="agregarServicioCreat" class="boton-simple">Crear nuevo</div>
                  
                 
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>        
        </div>
      </div>
    </div>
  </div>

</span>',

});