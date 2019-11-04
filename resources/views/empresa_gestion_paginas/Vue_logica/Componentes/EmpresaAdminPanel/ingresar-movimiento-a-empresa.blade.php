Vue.component('ingresar-movimiento-a-empresa' ,
{
props:[ 'empresa'],
data:function(){
    return {
     modal:'#modal-ingreso-caja',
     tipos_de_servicios: {!! json_encode(config('tipo_movimiento_empresas')) !!},
    
     servicio_elegido:'',
     se_cobra:'si',
     moneda: '$',
     nombre_a_ingresar:'',
     valor_ingresar:0,
     user:  {!! json_encode(Auth::user()) !!}

    }
},
methods:{
 abrir_modal:function(){
   $(this.modal).appendTo("body").modal('show'); 
 },
 elegir_lo_que_voy_a_agregar:function(tipo_servicio){
  this.servicio_elegido = tipo_servicio;
  this.nombre_a_ingresar = tipo_servicio.nombre;
 },
 cancelarIngreso:function(){
  this.poner_valor_de_cero();
 },
 poner_valor_de_cero:function(){
  this.servicio_elegido = '';
  this.moneda = '$';
  this.valor_ingresar = 0;
  this.nombre_a_ingresar = '';
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
 },
 ingresa_movimiento:function(){
      var url = '/ingresar_movimiento_a_empresa';

      var data = {  
                    empresa_id: this.empresa.id,
                        moneda: this.moneda,  
                         valor: this.valor_ingresar,
                    tipo_saldo: this.servicio_elegido.tipo_saldo,
                        nombre: this.nombre_a_ingresar  ,                      
                          paga: this.se_cobra

                 };  
      var vue = this;           

     axios.post(url,data).then(function (response){  
            var data = response.data;  
            

            if(data.Validacion == true)
            {
              app.cerrarModal(vue.modal);      
              app.empresa = data.empresa;       
              $.notify(data.Validacion_mensaje, "success");   

              vue.poner_valor_de_cero();       
               
            }
            else
            {
              $.notify(response.data.Validacion_mensaje, "error");
            }
           
           }).catch(function (error){

                     
            
           });
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
  },
  servicio_elegido_es_distinto_de_cobro:function(){
    if(this.servicio_elegido.nombre != 'Cobro')
    {
      return true;
    }
    else
    {
      return false;
    }
  },
}
,
template:'<span >
   <div  class="admin-user-boton-Crear panel-socio-agrega-margin-left-boton" v-on:click="abrir_modal" title="Ingresar un movimiento de caja">
       <i class="fas fa-cash-register"></i> Cobrar





       
  </div>

         <div class="modal fade" id="modal-ingreso-caja" tabindex="+1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel" v-if="servicio_elegido_comp">Ingresa el monto</h4>
           <h4 class="modal-title" id="myModalLabel" v-else> Facturar o cobrar algo a @{{empresa.name}}</h4>
          <button v-on:click="cancelarIngreso" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fas fa-times"></i></span></button>
          
        </div>
        <div class="modal-body text-center"> 
         <div v-if="servicio_elegido_comp" class="contiene-fase-2-ingreso-de-caja">

          <div class="formulario-label-fiel">
                      <label class="formulario-label" for="Nombre"> Detalle a ingresar  </label>
                      <input type="text" class="formulario-field"  v-model="nombre_a_ingresar" placeholder="Nombre"   />
            </div>
           
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

          

           <input type="text" name="" v-model="valor_ingresar" class="ingresar-input-valor">

           <div v-if="servicio_elegido_es_distinto_de_cobro" class="contiene-fase-2-moneda">
            <div class="flex-row-center flex-justifice-space-around get_width_80">
              <div class="contiene-opcion-moneda">
                <input type="radio" value="si" v-model="se_cobra">
                <label class="moneda-label" for="si">Paga ahora</label>
              </div>
              
              <div class="contiene-opcion-moneda">
                <input type="radio" value="no" v-model="se_cobra">
                <label class="moneda-label" for="no">Queda debiendo</label>
              </div>
            </div>
           </div>


           <div v-if="valor_ingresar > 0" class="ingreso-caja-aviso">
             Estás a punto de ingresar ésto a la empresa @{{empresa.name}}  : <strong>@{{servicio_elegido.nombre}}</strong>  por un valor de <strong>@{{moneda}} @{{valor_ingresar}} </strong> ¿está bién? . 
           </div>

           <div class="boton-simple" v-on:click="ingresa_movimiento">
             Ingresar
           </div>

           
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