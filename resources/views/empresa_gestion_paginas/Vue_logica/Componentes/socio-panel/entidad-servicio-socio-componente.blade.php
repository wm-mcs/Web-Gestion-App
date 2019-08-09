Vue.component('servicio-socio-lista' ,
{
props:['servicio'],  

data:function(){
    return {
      destroy_modal:false,
    }
},
mounted: function mounted () {        

      


},
methods:{

    borrar_servicio:function(servicio){


       var validation = confirm("¿Quieres eliminar el servicio?");

       if(!validation)
       {
        return '';
       }

       var url = '/borrar_servicio_de_socio' + servicio.id;

       var vue = this;

       axios.get(url).then(function(response){  
          
          if(response.data.Validacion == true)
          {

            vue.destroy_modal = true;
            vue.$emit('actualizar_socio',response.data.Socio);    
            vue.$emit('actualizar_servicios_de_socios',response.data.servicios); 

            

            $.notify(response.data.Validacion_mensaje, "success");  


          }
          else
          {
            $.notify(response.data.Validacion_mensaje, "warn");  
          }    
           
           
           }).catch(function (error){

                     
            
           });


    },
    EditarServicio:_.debounce(function(servicio){

       var url = '/editar_servicio_a_socio';

       var vue = this;

       var data = {servicio_a_editar:this.servicio};

       axios.post(url,data).then(function(response){ 


          
          if(response.data.Validacion == true)
          {
            
            
            vue.$emit('actualizar_servicios_de_socios',response.data.servicios); 
             $.notify(response.data.Validacion_mensaje, "success");
          }
          else
          {
            $.notify(response.data.Validacion_mensaje, "warn");
          }    
           
           
           }).catch(function (error){

                     
            
           });

    },1000)
    ,
    abrir_modal_editar:function(){

      
      

      $('#'+ this.open_modal).appendTo("body").modal('show');  

    },
    indicar_que_se_uso_hoy:function(){

       var validation = confirm("¿Quieres indicar que se usó este servicio?");

       if(!validation)
       {
        return '';
       }


       var url = '/indicar_que_se_uso_el_servicio_hoy';

       var vue = this;

       var data = {servicio_a_editar:this.servicio};

       axios.post(url,data).then(function(response){ 


          
          if(response.data.Validacion == true)
          {
            
            
            vue.$emit('actualizar_servicios_de_socios',response.data.servicios); 
             $.notify(response.data.Validacion_mensaje, "success");
          }
          else
          {
            $.notify(response.data.Validacion_mensaje, "warn");
          }    
           
           
           }).catch(function (error){

                     
            
           });







    }


},
computed:{

    esta_activo:function()
    {
        if( this.servicio.esta_vencido == true || this.servicio.se_consumio == true )
        {
          return false ;
        }
        else
        {
          return true;
        }
    },
    se_consumio:function(){

       if( this.servicio.se_consumio == true  )
        {
          return true ;
        }
        else
        {
          return false;
        }

    },
    es_clase:function(){



        if( this.servicio.tipo === "mensual")
        {
          return false ;
        }
        else
        {
          return true;
        }

    },
    open_modal:function(){
      
      return   'modal-editar-servicio-socio-'+ String(this.servicio.id);
    }


  
},
template:'


  <div class="contiene-entidad-lista-servicio">

       <div class="flex-row-center get_width_100 flex-justifice-space-between">
        <div class="entidad-lista-name" >
            
            @{{servicio.name}} 


            <span class="margin-left-8px simula_link" v-on:click="abrir_modal_editar" title="Editar el servicio">              
             <i class="fas fa-pen"></i>
            </span>
            

            <span  v-show="!servicio.se_consumio && es_clase"  class="margin-left-8px simula_link" v-on:click="indicar_que_se_uso_hoy" title="Marcar el servicio como ya usado">
              
              <i class="far fa-check-square"></i>
            </span>



            
            
         </div>
         <div v-if="es_clase" class="lista-estado-por-clase">
           <i class="fas fa-undo"></i> Tipo @{{servicio.tipo}}
         </div>
         <div v-else class="lista-estado-por-mensual">
           <i class="fas fa-hourglass-start"></i> Tipo @{{servicio.tipo}}
         </div>

        </div>
        <div>
            <div class="entidad-lista-servicio-contiene-fecha">
                <span class="entidad-lista-servicio-fecha" >Contratado el @{{servicio.fecha_contratado_formateada}}</span>                
                <span v-show="!servicio.esta_vencido" class="entidad-lista-servicio-fecha" >Se vence el @{{servicio.fecha_vencimiento_formateada}}</span> 
               

                <div v-show="servicio.esta_vencido" class="lista-estado-consumido" > <i class="fas fa-exclamation-circle"></i> Se venció el @{{servicio.fecha_vencimiento_formateada}}</div>
                <div v-show="esta_activo" class="lista-estado-activo" > <i class="fas fa-check"></i> Disponible</div>
                <div v-show="servicio.se_consumio" class="lista-estado-consumido" > <i class="fas fa-exclamation-circle"></i> Se consumió el @{{servicio.fecha_consumido_formateada}}</div>
            </div>
            
        </div>

        

             




         <div class="modal fade" :id="open_modal" tabindex="+1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div v-if="!destroy_modal" class="modal-header">
          <h4 class="modal-title" id="myModalLabel"> Editar @{{servicio.name}}</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fas fa-times"></i></span></button>
          
        </div>
        <div v-if="!destroy_modal" class="modal-body text-center"> 

                  <div class="form-group">
                      <label class="formulario-label" for="Nombre">Nombres  </label>
                      <input type="text" class="form-control"  v-model="servicio.name" placeholder="Nombre" required  />
                  </div> 
                   <div  class="form-group">
                      <label class="formulario-label" for="Nombre">¿Es por clase o mensual?  </label>
                      <select v-model="servicio.tipo" class="form-control">
                        <option>clase</option>
                        <option>mensual</option>
                      </select>
                  </div> 
                  <div class="form-group">
                      <label class="formulario-label" for="Nombre">Fecha de vencimiento  </label>
                      <input type="date" class="form-control"  v-model="servicio.fecha_vencimiento_formateada"  required  />
                  </div> 

                  <div v-show="se_consumio" class="form-group">
                      <label class="formulario-label" for="Nombre">¿ya se usó?  </label>
                      <select v-model="servicio.esta_consumido" class="form-control">
                        <option>si</option>
                        <option>no</option>
                      </select>
                  </div> 

                  <div v-show="se_consumio" class="form-group">
                      <label class="formulario-label" for="Nombre">Fecha de cuando se usó  </label>
                      <input type="date" class="form-control"  v-model="servicio.fecha_consumido_formateada"  required  />

                  </div> 
                
                  

                 
               

                


               

                  <div v-on:click="EditarServicio(servicio)" class="boton-simple">Editar</div>


                   <br>
                   <br>
                   <div  class="simula_link" v-on:click="borrar_servicio(servicio)">
                     Eliminar el servicio <i class="fas fa-trash-alt"></i>
                   </div>
                  
                 
        </div>
        <div v-else>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>           
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>        
        </div>
      </div>
    </div>
  </div>





























            
    </div>
       
       

        

         























  


'

}




);