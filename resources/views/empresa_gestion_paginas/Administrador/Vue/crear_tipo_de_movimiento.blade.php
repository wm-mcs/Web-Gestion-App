Vue.component('crear-tipo-de-movimientos' ,
{

data:function(){
    return {
     
     showModal: false,
     cargando:false

    }
},
methods:{

  
 

},
mounted: function () {
	

},

template:'
<div class="Boton-Fuente-Chica Boton-Primario-Relleno" @click="showModal = true">
  Crear un tipo de movimiento <i class="fas fa-plus"></i>

  <transition name="modal">
    <div class="modal-mask " @click="showModal = false">
      <div class="modal-wrapper">
        <div class="modal-container">

          <div class="modal-header">
            
          </div>

          <div class="modal-body">
            Hola
          </div>

          <div class="modal-footer">
           
              <button class="modal-default-button" @click="showModal = false">
                OK
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