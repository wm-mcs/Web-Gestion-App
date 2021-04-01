Vue.component("crear-actividad", {
  mixins: [onKeyPressEscapeCerrarModalMixIn,erroresMixIn],
  data: function () {
    return {
      cargando: false,
      datos_a_enviar: {
        name: "",
        empresa_id: this.$root.empresa.id,
        sucursal_id: this.$root.Sucursal.id,
        color:'#7168f3',
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
        color:'#7168f3'

      };
    },

    crear: function () {
      var url = "/crear_actividad";

      var data = this.datos_a_enviar;

      var vue = this;

      vue.cargando = true;
      vue.errores = [];

      axios
        .post(url, data)
        .then(function (response) {
          var data = response.data;

          if (data.Validacion == true) {
            vue.cargando = false;
            bus.$emit("se-creo-o-edito", "hola");
            vue.showModal = false;
            vue.limpiar_data_crear();
            $.notify(response.data.Validacion_mensaje, "success");
          } else {
            vue.cargando = false;
            vue.setErrores(data.Data);
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

                  <div class="formulario-label-fiel">
                    <fieldset class="float-label">
                      <input
                        name="color"
                        type="color"
                        class="input-text-class-primary"
                        v-model="datos_a_enviar.color"
                        required

                      />
                      <label for="color">Color</label>
                    </fieldset>


                  </div>

              <div class="col-12 formulario-label-fiel">
                <label class="formulario-label">¿Activo?</label>
                <select v-model="datos_a_enviar.estado" class="formulario-field">
                  <option>si</option>
                  <option>no</option>
                </select>

              </div>



              <transition name="fade-enter" v-if="errores.length > 0">
        <div class="col-12 my-2 py-2 background-error cursor-pointer"  >
          <div @click="handlerClickErrores" class="color-text-error mb-1" v-for="error in errores">@{{error[0]}}</div>
        </div>
      </transition>

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
