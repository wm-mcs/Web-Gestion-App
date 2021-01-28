var plan = {
  props: ["plan"],
  data: function() {
    return {
      cargando: false,
      showModal: false,
      imagen: ""
    };
  },
  methods: {

    editarPais: function() {
      var url = "/editar_plan";

      var data = { plan: this.plan };
      var vue = this;

      axios
        .post(url, data)
        .then(function(response) {
          var data = response.data;

          if (data.Validacion == true) {

            $.notify(response.data.Validacion_mensaje, "success");
          } else {
            $.notify(response.data.Validacion_mensaje, "error");
          }
        })
        .catch(function(error) {});
    }
  },
  template: `<div class="col-6 col-lg-4 p-1 ">
    <div class="p-3  border-radius-estandar borde-gris background-white h-100">
      <div class="row mx-0 align-items-center">

        <div class="col-12 mb-0   cursor-pointer" @click="showModal = true">
        <p class="h5 mb-1"><b>@{{plan.name}}</b></p>


          <p  class="mb-0" :class="plan.estado === 'si' ? 'color-text-success' : 'color-text-gris'"> @{{ plan.estado === 'si' ? 'Activo':'Desactivado'}}
        </p>
        </div>


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
                <h4 class="col-12 sub-titulos-class"> Editar @{{plan.name}}</h4>
                <div class="col-12 modal-mensaje-aclarador">
                  Editar los datos correspondientes al plan <b>@{{plan.name}}</b>.
                </div>
              </div>

              <div class="modal-body">

                <div class="row mx-0 contenedor-grupo-datos">





                  <div class="col-lg-6 formulario-label-fiel">
                    <label class="formulario-label">Nombre </label>
                    <input type="text" class="formulario-field" v-model="plan.name" placeholder="Nombre del plan" />
                  </div>


                  <div class="col-6 formulario-label-fiel">
                    <label class="formulario-label">¿Activo?</label>
                    <select v-model="plan.estado" class="formulario-field">
                        <option>si</option>
                        <option>no</option>
                    </select>
                   </div>


                  <div @click="editarPlan" class="mt-4 Boton-Fuente-Chica Boton-Primario-Sin-Relleno">
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
