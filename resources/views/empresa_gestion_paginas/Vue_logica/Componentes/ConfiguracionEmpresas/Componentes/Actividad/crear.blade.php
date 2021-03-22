Vue.component("crear-actividad", {
  mixins: [onKeyPressEscapeCerrarModalMixIn],
  data: function () {
    return {
      cargando: false,
      datos_a_enviar: {
        name: "",
        empresa_id: this.$root.empresa.id,
        sucursal_id: this.$root.Sucursal.id,
        estado: "si",
      },
      showModal: false,
    };
  },
  methods: {
    limpiar_data_crear: function () {
      this.datos_a_enviar = {
        name: "",
        estado: "si",

      };
    },

    crear: function () {
      var url = "/crear_actividad";

      var data = this.datos_a_enviar;

      var vue = this;

      axios
        .post(url, data)
        .then(function (response) {
          var data = response.data;

          if (data.Validacion == true) {
            vue.cargando = false;
            bus.$emit("se-creo-actividad", "hola");
            vue.showModal = false;
            vue.limpiar_data_crear();
            $.notify(response.data.Validacion_mensaje, "success");
          } else {
            vue.cargando = false;
            $.notify(response.data.Validacion_mensaje, "error");
          }
        })
        .catch(function (error) {
          vue.cargando = false;
          $.notify("Upsssssss.. algo pasó", "error");
        });
    },
  },
  computed: {},
  mounted: function () {},

  template: `<span>


  <button type="button" class="Boton-Fuente-Chica Boton-Primario-Relleno " @click="showModal = true">
   Crear actividad <i class="fas fa-plus"></i>
  </button>


  <transition name="modal" v-if="showModal">
    <div class="modal-mask ">
      <div class="modal-wrapper">
        <div class="modal-container position-relative">
        <span class="modal-cerrar-icono sub-titulos-class text-center color-text-gris" @click="showModal = !showModal">
          <i class="fas fa-times"></i>
        </span>


          <div class="row">
            <h4 class="col-12 sub-titulos-class" > Crear</h4>
            <div class="col-12 modal-mensaje-aclarador">

            </div>
          </div>

          <div class="modal-body">

            <div class="row  mx-0 ">


                <div class="formulario-label-fiel">
                    <fieldset class="float-label">
                      <input
                        name="name"
                        type="text"
                        class="input-text-class-primary"
                        v-model="datos_a_enviar.name"
                        required

                      />
                      <label for="name">Nombre</label>
                    </fieldset>
                  </div>

              <div class="col-12 formulario-label-fiel">
                <label class="formulario-label">¿Activo?</label>
                <select v-model="datos_a_enviar.estado" class="formulario-field">
                  <option>si</option>
                  <option>no</option>
                </select>

              </div>





              <div v-if="cargando" class="Procesando-text w-100">Procesado...</div>
              <div v-else class="w-100">
              <button type="button" @click="crear" class="mt-4 Boton-Fuente-Chica Boton-Primario-Sin-Relleno">
                 Confirmar
              </button>
              </div>
            </div>



          </div>

          <div class="modal-footer">

              <button class="modal-default-button" @click="showModal = false" >
                Cancelar
              </button>

          </div>
        </div>
      </div>
    </div>
  </transition>
</span>

`,
});
