Vue.component('tipo_de_movimiento_lista' ,
{
props['tipo_de_movimiento'],
data:function(){
    return {
     
     showModal: false,
     cargando:false,
     data_crear:''

    }
},
methods:{
  editar:function(){
    alert('agregar');
    bus.$emit('sucursal-set', response.data.sucursal); 
  }
 

},
mounted: function () {
  
 this.data_crear = this.tipo_de_movimiento;
},

template:'

<span>
<div class="col-6 col-lg-4 p-4 mb-3 background-gris-1" @click="showModal = true">
  Editar un tipo de movimiento <i class="fas fa-plus"></i>
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
                <input v-model="data_crear.name" type="text" min="1" class="formulario-field" placeholder="hola">
              </div>
              <div class="col-lg-6 formulario-label-fiel">
                <label class="formulario-label">¿Interactua con un socio?</label> 
                <div class="formulario-label-aclaracion">
                  ¿Tiene que ver con algo de un socio? Ejemplo: ingresar pago de cuota.
                </div>                
                <select v-model="data_crear.movimiento_de_empresa_a_socio" class="formulario-field">
                  <option>si</option>
                  <option>no</option>
                </select>
              </div>
              <div class="col-lg-6 formulario-label-fiel">
                <label class="formulario-label">¿Movimiento de la propia empresa?</label> 
                <div class="formulario-label-aclaracion">
                  Agregar un gasto de tarifas estatales sería un ejemplo.
                </div>                
                <select v-model="data_crear.movimiento_de_la_empresa" class="formulario-field">
                  <option>si</option>
                  <option>no</option>
                </select>
              </div>
              <div class="col-lg-6 formulario-label-fiel">
                <label class="formulario-label">¿Tipo de saldo?</label> 
                <select v-model="data_crear.tipo_saldo" class="formulario-field">
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
</span>



'
}




);