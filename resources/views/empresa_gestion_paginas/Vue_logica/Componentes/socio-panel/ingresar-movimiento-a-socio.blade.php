Vue.component('ingresar-movimiento-a-socio' ,
{
props:[ 'empresa','sucursal','socio'],
data:function(){
    return {
      cargando:false,
      showModal:false,
      tipos_de_movimientos:[],    
      servicio_elegido:'',
      se_cobra:'si',
      moneda: '$',
      valor_ingresar:0,
      nombre_a_ingresar:'',
      user:  {!! json_encode(Auth::user()) !!}
    }
},
methods:{
 abrir_modal:function(){
   
   this.showModal = true;
   if(this.tipos_de_movimientos.length === 0)
   {
    this.get_tipos_de_movimientos();
   }   

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
      var url = '/ingresar_movimiento_a_socio';

      var data = {  
                    empresa_id: this.empresa.id,
                        moneda: this.moneda,  
                         valor: this.valor_ingresar,
                    tipo_saldo: this.servicio_elegido.tipo_saldo,
                        nombre: this.nombre_a_ingresar,
                      socio_id: this.socio.id,
                          paga: this.se_cobra,
         tipo_de_movimiento_id: this.servicio_elegido.id
                 };  
      var vue = this;    

     vue.cargando = true;        

     axios.post(url,data).then(function (response){  
            var data = response.data;  
            

            if(data.Validacion == true)
            {

              vue.cargando = false;
              
              vue.$emit('actualizar_socio',response.data.Socio); 
              bus.$emit('sucursal-set', response.data.sucursal);  
              $.notify(data.Validacion_mensaje, "success");   

              vue.poner_valor_de_cero();       
               
            }
            else
            {
              vue.cargando = false;
              $.notify(response.data.Validacion_mensaje, "error");
            }
           
           }).catch(function (error){
             vue.cargando = false;
             $.notify(error, "error");  
                     
            
           });
},
get_tipos_de_movimientos:function(){
  var url = '/getMovimientosParaPanelDeIngresoDeMovimeintoAlSocio';

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
template:`
<span >
<div   class="admin-user-boton-Crear"  v-on:click="abrir_modal" title="Ingreso de movimiento de caja">
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
        <h4 class="col-12 sub-titulos-class" v-if="servicio_elegido_comp">Ingresa el monto </h4>
        <h4 class="col-12 sub-titulos-class" v-else> Ingresar movimiento a @{{socio.name}} </h4>
        <div class="col-12 modal-mensaje-aclarador" v-if="!servicio_elegido_comp">
          Para ingresar un movimiento debes elegir una de las opciones que estan abajo <i class="fas fa-hand-point-down"></i>
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

          <div class="row mb-2 align-items-center justify-content-center">
            
            
            <div class="col-8">
              <input type="number" name="" v-model="valor_ingresar" class="w-100 ingresar-input-valor"  >
            </div>
            
            
          </div>
          
          
          <p v-if="valor_ingresar > 0" class=" color-text-gris text-center">
            Estás a punto de ingresar ésto: <strong>@{{servicio_elegido.nombre}}</strong>  por un valor de <strong>@{{moneda}} @{{valor_ingresar}} </strong> ¿está bién? . 
          </p>
          <div v-if="$root.cargando" class="py-5 d-flex flex-row align-items-center justify-content-center">
              <div class="cssload-container">
                    <div class="cssload-tube-tunnel"></div>
              </div>
          </div>
          <div v-else class="boton-simple mt-4" v-on:click="ingresa_movimiento">
            @{{$root.boton_aceptar_texto}}
          </div>         
        </div>
        <div v-else  class="row">
          <div  v-if="tipos_de_movimientos.length" 
                v-for="movimiento in tipos_de_movimientos" 
                :key="movimiento.id"
                :title="movimiento.descripcion_breve"
                class="col-6 p-1"
                v-on:click="elegir_lo_que_voy_a_agregar(movimiento)" 
                >                
                  <div class="contiene-ingreso-opciones" :class="class_verificar_tipo_saldo(movimiento.tipo_saldo)">
                    @{{movimiento.name}}
                  </div>    
          </div>
          <div v-if="cargando" class=" w-100 d-flex flex-row my-5 align-items-center justify-content-center">
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


</span>`
}




);