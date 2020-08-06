Vue.component('tipo_de_movimiento_lista' ,
{
props:['tipo_de_movimiento'],
data:function(){
    return {
     
     showModal: false,
     cargando:false,
     data_editar:''

    }
},
methods:{
  editar:function(){
    alert('agregar');    
  }  
},
computed:{
  class_saldo:function(){
    
    return {
            'color-text-success':this.tipo_de_movimiento === 'deudor',
            'color-text-error':this.tipo_de_movimiento === 'acredor'     
           }
  }
},
mounted: function () {
  
 this.data_editar = this.tipo_de_movimiento;
},

template:'


  <div class="col-6 col-lg-4 p-4 mb-3 border-radius-estandar borde-gris background-white">
    <div class="row">
     <p class="col-10 mb-1">
      <b>@{{tipo_de_movimiento.name}}</b> 
     </p>
     <p class="col-2 text-center simula-link">
      <i  @click="showModal = true" class="far fa-edit"></i>
     </p>
     <p class="col-12 mb-1" :class="class_saldo">
       Saldo <b>@{{tipo_de_movimiento.tipo_saldo}}</b> 
     </p>
     <p class="col-12 mb-0 color-text-gris" >
       <small>@{{tipo_de_movimiento.descripcion_breve}}</small>
     </p>     
    </div>
   
     
      <transition name="modal" v-if="showModal">
    <div class="modal-mask ">
      <div class="modal-wrapper">
        <div class="modal-container">

          <div class="modal-header">
            <h3></h3>
          </div>

          <div class="modal-body">
            
            <div class="row">
              <div class="col-lg-6 formulario-label-fiel">
              <label class="formulario-label">Nombre</label> 
                <input v-model="data_editar.name" type="text" min="1" class="formulario-field" placeholder="hola">
              </div>
              <div class="col-lg-6 formulario-label-fiel">
                <label class="formulario-label">¿Interactua con un socio?</label> 
                <div class="formulario-label-aclaracion">
                  ¿Tiene que ver con algo de un socio? Ejemplo: ingresar pago de cuota.
                </div>                
                <select v-model="data_editar.movimiento_de_empresa_a_socio" class="formulario-field">
                  <option>si</option>
                  <option>no</option>
                </select>
              </div>
              <div class="col-lg-6 formulario-label-fiel">
                <label class="formulario-label">¿Movimiento de la propia empresa?</label> 
                <div class="formulario-label-aclaracion">
                  Agregar un gasto de tarifas estatales sería un ejemplo.
                </div>                
                <select v-model="data_editar.movimiento_de_la_empresa" class="formulario-field">
                  <option>si</option>
                  <option>no</option>
                </select>
              </div>
              <div class="col-lg-6 formulario-label-fiel">
                <label class="formulario-label">¿Tipo de saldo?</label> 
                <select v-model="data_editar.tipo_saldo" class="formulario-field">
                  <option>deudor</option>
                  <option>acredor</option>
                </select>
                
              </div>

              <div @click="editar" class="mt-4 Boton-Fuente-Chica Boton-Primario-Sin-Relleno">
                 Confirmar
              </div>
            </div>
            


          </div>

          <div class="modal-footer">
           
              <button class="modal-default-button"  @click="showModal = false">
                Cancelar
              </button>
           
          </div>
        </div>
      </div>
    </div>
  </transition>
  </div>  






'
}




);