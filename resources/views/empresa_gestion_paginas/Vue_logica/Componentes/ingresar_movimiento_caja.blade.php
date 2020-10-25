Vue.component('ingresar-movimiento-caja' ,
{
props:[ 'empresa','sucursal'],
data:function(){
    return {
     cargando:false, 
     showModal:false,
     modal:'#modal-ingreso-caja',
     tipos_de_movimientos: [],
     servicio_elegido:'',
     moneda: '$',
     nombre_a_ingresar:'',
     valor_ingresar:0,
     user:  {!! json_encode(Auth::user()) !!}

    }
},
mounted: function mounted () {        
      
   

},
methods:{
 abrir_modal:function(){
   $(this.modal).appendTo("body").modal('show'); 
   if(this.tipos_de_movimientos.length === 0)
   {
    this.get_tipos_de_movimientos();
   }   
   
 },
 elegir_lo_que_voy_a_agregar:function(tipo_servicio){
  this.servicio_elegido = tipo_servicio;
  this.nombre_a_ingresar = tipo_servicio.name;
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
      var url = '/ingresar_movimiento_caja';

      var data = {  
                    empresa_id: this.empresa.id,
                        moneda: this.moneda,  
                         valor: this.valor_ingresar,
                    tipo_saldo: this.servicio_elegido.tipo_saldo,
                        nombre: this.nombre_a_ingresar,
         tipo_de_movimiento_id: this.servicio_elegido.id
                 };  
      var vue = this;  
      app.cargando = true;         

     axios.post(url,data).then(function (response){  
            var data = response.data;  
            

            if(data.Validacion == true)
            {
              app.cargando = false;
              app.cerrarModal(vue.modal);
              bus.$emit('sucursal-set', response.data.sucursal);  
              $.notify(data.Validacion_mensaje, "success");   

              vue.poner_valor_de_cero();       
               
            }
            else
            { app.cargando = false;
              $.notify(response.data.Validacion_mensaje, "error");
            }
           
           }).catch(function (error){

             app.cargando = false;
             $.notify(error, "error");       
            
           });
},
get_tipos_de_movimientos:function(){
  var url = '/getMovimientosParaPanelDeIngresoDeMovimeintoDeCaja';

  var data = {  
               empresa_id: this.empresa.id
             };  
  var vue = this; 
  vue.cargando = true;         

  axios.post(url,data).then(function (response){  
          var data = response.data;         

          if(data.Validacion == true)
          {
            vue.cargando = false;
            vue.tipos_de_movimientos = data.Data;
          }
          else
          { vue.cargando = false;
            $.notify(response.data.Validacion_mensaje, "error");
          }
        
        }).catch(function (error){
            vue.cargando = false;
            $.notify(error, "error");    
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
  }
}
,
template:`<span >
<div   class="admin-user-boton-Crear"  v-on:click="showModal = !showModal" title="Ingreso de movimiento de caja">
    <i class="fas fa-cash-register"></i>   
</div>
<transition name="modal" v-if="showModal">
<div class="modal-mask ">
  <div class="modal-wrapper">
    <div class="modal-container position-relative">
    <span class="modal-cerrar-icono sub-titulos-class text-center color-text-gris" @click="showModal = !showModal">
      <i class="fas fa-times"></i>
    </span>

      
      <div class="row">
        <h4 class="ol-12 sub-titulos-class" v-if="servicio_elegido_comp">Ingresa el monto </h4>
        <h4 class="modal-title" v-else>Ingresar movimiento de cajaen sucursal @{{sucursal.name}}</h4>
        <div class="col-12 modal-mensaje-aclarador" v-if="!servicio_elegido_comp">
          Para ingresar un movimiento debes elegir alguna de las opciones que estan abajo.
        </div>
      </div>      

      <div class="modal-body">  
          <div v-if="servicio_elegido_comp" class="contiene-fase-2-ingreso-de-caja">
            <div class="col-12 mb-2">
              <label class="formulario-label" for="Nombre"> Detalle a ingresar  </label>
              <input type="text" class="formulario-field"  v-model="nombre_a_ingresar" placeholder="Nombre"   />
            </div> 
          
          <div v-if="$root.aceptaDolares" class="contiene-fase-2-moneda">
            <div class="row mb-2">
              <div class="col-6">
                <input type="radio" value="$" v-model="moneda">
                <label class="moneda-label" for="$">Pesos</label>
              </div>
              
              <div  class="col-6">
                <input type="radio" value="U$S" v-model="moneda">
                <label class="moneda-label" for="U$S">Dolares</label>
              </div>
            </div>
          </div>

          <div class="row mb-2">
            <p  class="col-4">@{{moneda}}</p>
          </div>
          <div class="col-8 ">
            <input type="text" name="" v-model="valor_ingresar" class="ingresar-input-valor"  >
          </div>
          
          <p v-if="valor_ingresar > 0" class=" color-text-gris text-center">
            Estás a punto de ingresar ésto: <strong>@{{servicio_elegido.nombre}}</strong>  por un valor de <strong>@{{moneda}} @{{valor_ingresar}} </strong> ¿está bién? . 
          </p>
          <div v-if="$root.cargando" class="Procesando-text">
              <div class="cssload-container">
                    <div class="cssload-tube-tunnel"></div>
              </div>
          </div>
          <div v-else class="boton-simple" v-on:click="ingresa_movimiento">
            @{{$root.boton_aceptar_texto}}
          </div>         
        </div>
        <div v-else class="" class="row ">
          <div  v-if="tipos_de_movimientos.length" 
                v-for="movimiento in tipos_de_movimientos" 
                :key="movimiento.id"
                :title="movimiento.descripcion_breve"
                class="col-6"
                v-on:click="elegir_lo_que_voy_a_agregar(movimiento)" 
                >                
                  <div :class="class_verificar_tipo_saldo(movimiento.tipo_saldo)">
                    @{{movimiento.name}}
                  </div>    
          </div>
          <div v-if="cargando" class="Procesando-text">
            <div class="cssload-container">
                <div class="cssload-tube-tunnel"></div>
            </div>
          </div>           
        </div>
      </div>     

      <div class="modal-footer">           
        <button class="modal-default-button"   @click="showModal = !showModal">
          @{{$root.boton_cancelar_texto}}
        </button>           
      </div>

    </div>
  </div>
</div>
</transition>


























   <div  class="admin-user-boton-Crear mr-lg-2" v-on:click="abrir_modal" title="Ingresar un movimiento de caja">
       
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
         
                 
                 
        </div>
        <div class="modal-footer">
          
          <button v-on:click="cancelarIngreso" type="button" class="btn btn-default" data-dismiss="modal">@{{$root.boton_cancelar_texto}}</button>        
        </div>
      </div>
    </div>
  </div>













</span>`

}




);