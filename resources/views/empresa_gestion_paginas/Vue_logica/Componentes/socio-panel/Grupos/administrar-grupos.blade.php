Vue.component("administrar-grupos", {
  mixins: [onKeyPressEscapeCerrarModalMixIn,erroresMixIn],
  props:['socio'],
  data: function () {
    return {
      cargando: false,
      empresa_id: this.$root.empresa.id,
      sucursal_id: this.$root.Sucursal.id,
      grupos:[],
      grupos_de_socio:[],
      showModal: false,
    };
  },
  methods: {
    limpiar_data_crear: function () {

    },

    getGrupos: function () {
      var url  = "/crear_grupo";
      var data = {};

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
    getGruposDeSocio:function (){

    },
  },
  computed: {},
  mounted: function () {},

  template: `<span>


  <button type="button" class="Boton-Fuente-Chica Boton-Primario-Relleno" @click="showModal = true">
   Crear  <i class="fas fa-plus"></i>
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
