var pais = {
	props: ["pais"],
	data: function() {
		return {
			cargando: false,
			showModal: false
		};
	},
	template: `<div class="col-6 col-lg-4 p-1 ">

  <div class="p-3 mb-3 border-radius-estandar borde-gris background-white h-100">
    <div class="row mx-0">
      <p class="col-10 mb-1 text-color-black ">
        <b>@{{pais.name}}</b>
      </p>
      
    </div>


    <transition name="modal" v-if="showModal">
      <div class="modal-mask ">
        <div class="modal-wrapper">
          <div class="modal-container position-relative">
            <span class="modal-cerrar-icono sub-titulos-class text-center color-text-gris"
              @click="showModal = !showModal">
              <i class="fas fa-times"></i>
            </span>


            <div class="row">
              <h4 class="col-12 sub-titulos-class"> Editar @{{pais.name}}</h4>
              <div class="col-12 modal-mensaje-aclarador">
                Editar
              </div>
            </div>

            <div class="modal-body">

              <div class="row">
                
                <div  class="mt-4 Boton-Fuente-Chica Boton-Primario-Sin-Relleno">
                  Confirmar
                </div>
              </div>



            </div>

            <div class="modal-footer">

              <button class="modal-default-button" @click="showModal = false">
                Cancelar
              </button>

            </div>
          </div>
        </div>
      </div>
    </transition>
  </div>
</div>`
};
