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
      sucursales: []
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
  <div class="col-6">
    <div>
      <label :class="[queMostrar == 'reserva' ? 'Boton-Primario-Relleno' : 'Boton-Primario-Sin-Relleno', 'Boton-Fuente-Muy-Chica']">
        <input style="visibility:hidden;"  type="radio" value="reserva" v-model="queMostrar"> RESERVAR
      </label>
    </div>
  </div>
  <div class="col-6">
      <label :class="[queMostrar == 'rutinas' ? 'Boton-Primario-Relleno' : 'Boton-Primario-Sin-Relleno', 'Boton-Fuente-Muy-Chica']">
        <input style="visibility:hidden;" type="radio" value="rutinas" v-model="queMostrar"> RUTINAS
      </label>
  </div>

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
