Vue.component("componente-general-reservas", {
  mixins: [onKeyPressEscapeCerrarModalMixIn, erroresMixIn],
  components: {
    reservas: Reservas
  },
  props: ["empresa", "default-que-mostrar"],
  data: function() {
    return {
      cargando: false,
      showModal: false,
      queMostrar: this.defaultQueMostrar,
      sucursales: [],
      abrirMenu: false
    };
  },
  methods: {
    getSucursales: function() {
      var url = "/get_sucursales_public";

      var data = {};

      var vue = this;

      vue.cargando = true;
      vue.errores = [];

      axios
        .post(url, data)
        .then(function(response) {
          var data = response.data;

          if (data.Validacion == true) {
            vue.cargando = false;
            vue.sucursales = data.Data;
          } else {
            vue.cargando = false;
            vue.setErrores(data.Data);
            $.notify(response.data.Validacion_mensaje, "error");
          }
        })
        .catch(function(error) {
          vue.cargando = false;
          $.notify("Upsssssss.. algo pasó", "error");
        });
    }
  },
  computed: {},
  mounted: function() {
    this.getSucursales();
  },
  created() {},

  template: `
  <div v-if="!cargando" class="w-100 row ">

  <div class="col-12 mb-3 d-flex flex-column align-items-center cursor-pointer">
      <div @click="abrirMenu = !abrirMenu" class="btn btn-outline-primary"><i class="fas fa-bars"></i></div>
  </div>
  <transition name="modal" v-if="abrirMenu">
  <div class="modal-mask ">
    <div class="modal-wrapper">
      <div class="modal-container position-relative">
      <span class="modal-cerrar-icono sub-titulos-class text-center color-text-gris" @click="abrirMenu = !abrirMenu">
        <i class="fas fa-times"></i>
      </span>


        <div class="row">
          <h4 class="col-12 sub-titulos-class" > Menú</h4>
          <div class="col-12 modal-mensaje-aclarador">

          </div>



        </div>


        <div class="modal-body">

         <div class="row mx-0">
          <div class="col-12">
            <div>
              <label :class="[queMostrar == 'reserva' ? 'text-color-primary' : 'color-text-gris', 'h3 mb-2']">
                <input style="visibility:hidden;"  type="radio" value="reserva" v-model="queMostrar"> RESERVAR <span v-if="queMostrar == 'reserva'">  <i class="fas fa-hand-point-left"></i> </span>
              </label>
            </div>
          </div>
          <div class="col-12">
              <label :class="[queMostrar == 'rutinas' ? 'text-color-primary' : 'color-text-gris', 'h3 mb-2']">
                <input style="visibility:hidden;" type="radio" value="rutinas" v-model="queMostrar"> RUTINAS <span v-if="queMostrar == 'rutinas'">  <i class="fas fa-hand-point-left"></i> </span>
              </label>
          </div>

         </div>



        </div>

        <div class="modal-footer">

            <button class="modal-default-button" @click="abrirMenu = false" >
              Cancelar
            </button>

        </div>
      </div>
    </div>
  </div>
</transition>




  <div class="col-12 mt-4 ">

  <div class="border borde-primary rounded background-gris-1 p-2">
    <reservas :sucursales="sucursales" :empresa="empresa" v-if="queMostrar == 'reserva'">

    </reservas>

    <div  v-if="queMostrar == 'rutinas'">
        HOLA @{{queMostrar}}
    </div>
  </div>


  </div>








  </div>
  <div v-else class="my-5  Procesando-text w-100">
  <div class="cssload-container">
      <div class="cssload-tube-tunnel"></div>
  </div>
</div>


`
});
