Vue.component('servicio-renovacion-empresa-lista' ,
{
props:[ 'servicio_renovacion' ],
data:function(){
    return {
     se_renueva:this.servicio_renovacion.se_renueva_automaticamente,

    }
},
methods:{

    actualizar_renovacion:function(){

      this.se_renueva = this.servicio_renovacion.se_renueva_automaticamente;
      

      var url  = '/editar_servicio_renovacion_empresa';

      var data = {se_renueva_automaticamente:this.se_renueva,
                                  empresa_id:this.servicio_renovacion.empresa_id,
                      servicio_renovacion_id:this.servicio_renovacion.id};

      var vue = this;

      axios.post(url,data).then(function (response){  
            var data = response.data;  
            

            if(data.Validacion == true)
            {
                
              app.empresa =  data.empresa;
              $.notify(data.Validacion_mensaje, "success");      
            }
            else
            {
              $.notify(response.data.Validacion_mensaje, "warn");
            }
           
      }).catch(function (error){}); 
    }

},
template:'<div class="contiene-se-renueva">

  
   <span class="se-renueva-name">@{{servicio_renovacion.servicio_tipo.name}} </span>
   <span class="se-renueva-ULTIMA">Última renovación: @{{servicio_renovacion.fecha_de_la_ultima_renovacion}} </span>

   <div class="sub-contiene-se-renueva">
     
   
              <span class="se-renueva-automaticamente">¿Se renueva automáticamente? </span>
        <div class="flex-row-center flex-justifice-space-around get_width_70">
           <div class="contiene-re-renueva-label-input">
                <input type="radio" value="si" v-on:change="actualizar_renovacion" v-model="servicio_renovacion.se_renueva_automaticamente">
                <label class="renueva-label" for="si">Si</label>
              </div>
              
              <div class="contiene-re-renueva-label-input">
                <input type="radio" value="no" v-on:change="actualizar_renovacion" v-model="servicio_renovacion.se_renueva_automaticamente">
                <label class="renueva-label" for="no">No</label>
              </div>
        </div>
             
   </div>
  

</div>'

}




);