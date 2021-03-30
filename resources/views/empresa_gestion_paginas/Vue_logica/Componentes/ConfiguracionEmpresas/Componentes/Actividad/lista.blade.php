var ListaActividad = {
  mixins: [onKeyPressEscapeCerrarModalMixIn],
  props: ["entidad"],
  data: function () {
    return {
      cargando: false,
      entidadAEditar: this.entidad,
      showModal: false,
      
    };
  },
  methods: {
    edit: function () {
      var url = "/editar_actividad";

      var data = {
        empresa_id: this.$root.empresa.id,
        id: this.entidadAEditar.id,
        name: this.entidadAEditar.name,
        estado: this.entidadAEditar.estado,
        color: this.entidadAEditar.color,
      };

      var vue = this;
      vue.cargando = true;

      axios
        .post(url, data)
        .then(function (response) {
          var data = response.data;

          if (data.Validacion == true) {
            vue.cargando = false;

            vue.showModal = false;
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
  mounted: function () {
   
  },
  created() {},

  template: `
  <div class="col-4">

  <div>
    <h3 class="simula_link" @click="showModal = true" > @{{entidadAEditar.name}}</h3>
  </div>
  <transition name="modal" v-if="showModal">
    <div class="modal-mask ">
      <div class="modal-wrapper">
        <div class="modal-container position-relative">
        <span class="modal-cerrar-icono sub-titulos-class text-center color-text-gris" @click="showModal = !showModal">
          <i class="fas fa-times"></i>
        </span>


          <div class="row">
            <h4 class="col-12 sub-titulos-class" > Editar @{{entidadAEditar.name}}</h4>
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
                        v-model="entidadAEditar.name"
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
                        v-model="entidadAEditar.color"
                        required

                      />
                      <label for="color">Color</label>
                    </fieldset>

                    
                  </div>

              <div class="col-12 formulario-label-fiel">
                <label class="formulario-label">¿Activo?</label>
                <select v-model="entidadAEditar.estado" class="formulario-field">
                  <option>si</option>
                  <option>no</option>
                </select>

              </div>





              <button v-if="cargando != true" type="button" @click="edit" class="mt-4 Boton-Fuente-Chica Boton-Primario-Sin-Relleno">
                 Editar
              </button>
              <div v-else class="my-3  Procesando-text w-100">
        <div class="cssload-container">
            <div class="cssload-tube-tunnel"></div>
        </div>
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




  </div>

`,
};
