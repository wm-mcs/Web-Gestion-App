Vue.component('servicio-renovacion-lista' ,
{
props:[ 'empresa','servicio_renovacion' ],
data:function(){
    return {
     

    }
},
methods:{

    

},
template:'<div class="">

  
   <span class="se-renueva-name">@{{servicio_renovacion.servicio_tipo.name}} </span>
   <span class="se-renueva-ULTIMA">Última renovación: @{{servicio_renovacion.fecha_ultima_renovacion}} </span>
   <span >Se renueva automáticamente </span>
   <div class="flex-row-center flex-justifice-space-around get_width_100">
              <div class="contiene-opcion-moneda">
                <input type="radio" value="si" v-model="servicio_renovacion.se_renueva_automaticamente">
                <label class="moneda-label" for="si">Si</label>
              </div>
              
              <div class="contiene-opcion-moneda">
                <input type="radio" value="no" v-model="servicio_renovacion.se_renueva_automaticamente">
                <label class="moneda-label" for="no">No</label>
              </div>
   </div>
  

</div>'

}




);