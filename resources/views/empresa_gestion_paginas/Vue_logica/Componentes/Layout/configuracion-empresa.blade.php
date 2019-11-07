Vue.component('configuracion-empresa' ,
{
props:[ 'empresa' ],
data:function(){
    return {
     modal_nombre:'#modal-configurar-empresa'

    }
},
methods:{
abrir_modal:function(){
  app.abrirModal(this.modal_nombre);
  },

actualizar_datos:function(){


      var url  = '/editar_empresa_renovacion_automatica';

      var data = {actualizar_servicios_socios_automaticamente:this.empresa.actualizar_servicios_socios_automaticamente,
                                        empresa_id:this.empresa.id,};

      var vue = this;

      axios.post(url,data).then(function (response){  
            var data = response.data;  
            

            if(data.Validacion == true)
            {
                
              app.empresa = data.emrpesa;  
              $.notify(data.Validacion_mensaje, "success");      
            }
            else
            {
              $.notify(response.data.Validacion_mensaje, "warn");
            }
           
      }).catch(function (error){}); 

}
    

},
template:'  <span class="contiene-sucursal" v-on:click="abrir_modal"> <i class="fas fa-cog"></i> Empresa


     <div class="modal fade" id="modal-configurar-empresa" tabindex="+1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"><i class="fas fa-cog"></i> Configuración de @{{empresa.name}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fas fa-times"></i></span></button>
                
              </div>
              <div class="modal-body text-center"> 



            <span class="se-renueva-automaticamente">¿Se renueva automáticamente? </span>
            <div class="flex-row-center flex-justifice-space-around get_width_70">
              <div class="contiene-re-renueva-label-input">
                <input type="radio" value="si" v-on:change="actualizar_datos" v-model="empresa.actualizar_servicios_socios_automaticamente">
                <label class="renueva-label" for="si">Si</label>
              </div>
              
              <div class="contiene-re-renueva-label-input">
                <input type="radio" value="no" v-on:change="actualizar_datos" v-model="empresa.actualizar_servicios_socios_automaticamente">
                <label class="renueva-label" for="no">No</label>
              </div>

               Datos acá
                     

                        
                       
              </div>
              
            </div>
          </div>
      </div>



    </span> '

}




);

