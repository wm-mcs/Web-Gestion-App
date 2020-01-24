Vue.component('servicio-empresa-lista' ,
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


    ditintoDeNull:function(valor){
      if(valor != null)
      {
        return valor;
      }
      return false;
    },

    borrar_servicio:function(servicio){


       var validation = confirm("¿Quieres eliminar el servicio?");

       if(!validation)
       {
        return '';
       }

       var url  = '/borrar_servicio_de_empresa';

       var vue  = this;

       app.cargando = true;

       var data = {
                   socio_id:this.servicio.socio_id,
                servicio_id:this.servicio.id,
                 empresa_id:this.servicio.empresa_id

                  };

       axios.post(url,data).then(function(response){  
          
          if(response.data.Validacion == true)
          {
            app.cargando = false;
            var id_modal = '#'+vue.open_modal;           
            app.cerrarModal(id_modal);  
            app.empresa = response.data.empresa; 
            

            

            $.notify(response.data.Validacion_mensaje, "success");  


          }
          else
          { 
            app.cargando = false;
            $.notify(response.data.Validacion_mensaje, "warn");  
          }    
           
           
           }).catch(function (error){

                     
            
           });


    },
    EditarServicio:_.debounce(function(servicio){

       var url = '/editar_servicio_a_empresa';

       var vue = this;

       var data = {servicio_a_editar:this.servicio,
                servicio_id:this.servicio.id,
                 empresa_id:this.servicio.empresa_id };

       axios.post(url,data).then(function(response){ 


          
          if(response.data.Validacion == true)
          {
            
              var id_modal = '#'+vue.open_modal;           
              app.cerrarModal(id_modal); 
             app.empresa = response.data.empresa;
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
    open_modal:function(){
      
      return   'modal-editar-servicio-socio-'+ String(this.servicio.id);
    }
    


  
},
template:'


  <div class="contiene-entidad-lista-servicio">

       <div class="flex-row-start get_width_100 flex-justifice-space-between">
        
        <div class="flex-column-start get_width_50">
          
       
              <div class="entidad-lista-name" >
                  @{{servicio.name}} 
                  <span class="margin-left-8px simula_link" v-on:click="abrir_modal_editar" title="Editar el servicio">              
                   <i class="fas fa-pen"></i>
                  </span>
              </div>
              <div class="flex-row-center entidad-lista-servicio-fecha">
               Precio: @{{servicio.moneda}} @{{servicio.valor}} 
              </div>
                  

                              
               
             
              

              <div  class="entidad-lista-servicio-fecha" > ID: @{{servicio.id}}</div>



        </div>   
            
        <div class="flex-column-end get_width_50 padding-4px">
          
        
        
         <div  class="lista-estado-por-mensual">
           <i class="fas fa-hourglass-start"></i> Tipo @{{servicio.tipo}}
         </div>

        
        
            <div class="entidad-lista-servicio-contiene-fecha">
                <span class="entidad-lista-servicio-fecha" >Contratado el @{{servicio.fecha_contratado_formateada}}</span>                
                <span v-show="!servicio.esta_vencido" class="entidad-lista-servicio-fecha" >Se vence el @{{servicio.fecha_vencimiento_formateada}}</span> 
               

                <div v-show="servicio.esta_vencido" class="lista-estado-consumido" > <i class="fas fa-exclamation-circle"></i> Se venció el @{{servicio.fecha_vencimiento_formateada}}</div>  
                
                
            </div>

            <div v-show="esta_activo" class="lista-estado-activo" > 
                <i class="fas fa-check"></i> Disponible
            </div>
            
        

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
                  <div class="form-group">
                      <label class="formulario-label" for="Nombre">Fecha de vencimiento  </label>
                      <input type="date" class="form-control"  v-model="servicio.fecha_vencimiento_formateada"  required  />
                  </div> 

               

                 
                
                  

                 
               

                


               

                  <div v-on:click="EditarServicio(servicio)" class="boton-simple">Editar</div>


                   <br>
                   <br>
                   <div v-if="esta_activo" class="simula_link" v-on:click="borrar_servicio(servicio)">
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