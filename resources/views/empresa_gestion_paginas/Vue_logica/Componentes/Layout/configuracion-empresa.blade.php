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
                                        empresa_id:this.empresa.id};

      var vue = this;

      axios.post(url,data).then(function (response){  
            var data = response.data;  
            

            if(data.Validacion == true)
            {
                
              app.empresa = data.empresa;  
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


          <div class="contiene-linea-configuracion">
            <span class="titulo-linea-seccion">¿Los servicios se renuevan automáticamente? </span>
            <span class="aclaracion-linea-seccion">
              Si ésta función está en “si”  el sistema de forma diaria ira buscando los socios que habían contratado previamente algún servicio mensual y se lo renovará de forma automática unos días antes de que se venza. La <strong>fecha de vencimiento del nuevo servicio será un mes posterior a la fecha de su último servicio</strong>  contratado. Esto generará un <strong>cargo para el socio y se verá reflejado en su estado de cuenta</strong> . En caso de que el socio tenga deudas, no se renovará de forma automática

            </span>
            <br>
            <br>
            <div class="flex-row-center flex-justifice-space-around get_width_70">
              <div class="contiene-re-renueva-label-input">
                <input type="radio" value="si" v-on:change="actualizar_datos" v-model="empresa.actualizar_servicios_socios_automaticamente">
                <label class="renueva-label" for="si">Si</label>
              </div>
              
              <div class="contiene-re-renueva-label-input">
                <input type="radio" value="no" v-on:change="actualizar_datos" v-model="empresa.actualizar_servicios_socios_automaticamente">
                <label class="renueva-label" for="no">No</label>
              </div>

               
              </div>
          </div>


                        
                       
              </div>
              
            </div>
          </div>
      </div>



    </span> '

}




);

