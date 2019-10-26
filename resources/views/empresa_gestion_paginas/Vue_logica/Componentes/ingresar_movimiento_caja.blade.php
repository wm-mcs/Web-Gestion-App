Vue.component('ingresar-movimiento-caja' ,
{
props:[ 'empresa','sucursal'],
data:function(){
    return {
     modal:'#modal-ingreso-caja',
     tipos_de_servicios: {!! json_encode(config('tipo_movimientos_de_caja')) !!},
     servicio_elegido:'',
     moneda: '$'

    }
},
methods:{
 abrir_modal:function(){
   $(this.modal).appendTo("body").modal('show'); 
 },
 elegir_lo_que_voy_a_agregar:function(tipo_servicio){
  this.servicio_elegido = tipo_servicio;
 },
 cancelarIngreso:function(){
  this.servicio_elegido = '';
 },
 class_verificar_tipo_saldo:function(saldo){
 if(saldo == 'deudor'){
  return {
      
      'contiene-ingreso-opciones-duedor': true,
      'contiene-ingreso-opciones':true 
    }
 }
 else
 {
  return {
      
      'contiene-ingreso-opciones-acredor': true,
      'contiene-ingreso-opciones':true 
    }
 }
 }

    

},
computed:{
  servicio_elegido_comp:function(){
    if(this.servicio_elegido != '')
    {
      return true;
    }
    else
    {
      return false;
    }
  }
}
,
template:'<span >
   <div  class="admin-user-boton-Crear" v-on:click="abrir_modal" title="Ingresar un movimiento de caja">
       <i class="fas fa-cash-register"></i>





       
  </div>

         <div class="modal fade" id="modal-ingreso-caja" tabindex="+1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel" v-if="servicio_elegido_comp">Ingresa el monto</h4>
           <h4 class="modal-title" id="myModalLabel" v-else>Ingresar movimiento en sucursal @{{sucursal.name}}</h4>
          <button v-on:click="cancelarIngreso" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fas fa-times"></i></span></button>
          
        </div>
        <div class="modal-body text-center"> 
         <div v-if="servicio_elegido_comp" class="contiene-fase-2-ingreso-de-caja">
           
           <div class="contiene-fase-2-moneda">
            <div class="flex-row-center flex-justifice-space-around get_width_40">
              <div class="contiene-opcion-moneda">
                <input type="radio" value="$" v-model="moneda">
                <label class="moneda-label" for="$">Pesos</label>
              </div>
              
              <div class="contiene-opcion-moneda">
                <input type="radio" value="U$S" v-model="moneda">
                <label class="moneda-label" for="U$S">Dolares</label>
              </div>
            </div>
              

           </div>
           <div v-on:click="cancelarIngreso">Cancelar</div>
         </div>
         <div v-else class="" class="contiene-ingreso-de-caja-opciones">
           <div v-for="servicio in tipos_de_servicios" v-on:click="elegir_lo_que_voy_a_agregar(servicio)" 
                       :class="class_verificar_tipo_saldo(servicio.tipo_saldo)">
             @{{servicio.nombre}}
           </div>
         </div>
                 
                 
        </div>
        <div class="modal-footer">
          <button v-on:click="cancelarIngreso" type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>        
        </div>
      </div>
    </div>
  </div>













</span>'

}




);