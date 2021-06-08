Vue.component("avisos-empresa-generales", {
  mixins: [onKeyPressEscapeCerrarModalMixIn],
  components: {
    "aviso-item": avisoItem
  },

  props: ["admin"],

  data: function() {
    return {
      empresa: this.$root.empresa,
      avisos: [],
      cargando: false,
      showModal: false,
      mostrarCrearMensaje: false,
      creando: false,
      tipo_de_mensaje_opciones: ["success", "error", "info", "warning"],
      dataCrear: {
        empresa_id: this.$root.empresa.id,
        type: "",
        title: "",
        text: "",
        call_to_action: "",
        call_to_action_url: ""
      }
    };
  },
  methods: {
    setAviso: function() {},
    getAvisos: function() {
      var url = "/get_avisos_de_esta_empresa_sin_leer";
      var vue = this;
      vue.cargando = true;

      let data = { empresa_id: this.empresa.id };
      axios
        .post(url, data)
        .then(function(response) {
          var data = response.data;

          if (data.Validacion == true) {
            vue.avisos = data.Data;

            vue.cargando = false;
          } else {
            $.notify(response.data.Validacion_mensaje, "error");
            vue.cargando = false;
          }
        })
        .catch(function(error) {
          vue.cargando = false;
        });
    },
    crear: function() {
      var url = "/crear_aviso_empresa";
      var vue = this;
      vue.creando = true;

      let data = this.dataCrear;
      axios
        .post(url, data)
        .then(function(response) {
          var data = response.data;

          if (data.Validacion == true) {
            vue.getAvisos();

            vue.creando = false;
            vue.mostrarCrearMensaje = false;
          } else {
            $.notify(response.data.Validacion_mensaje, "error");
            vue.creando = false;
          }
        })
        .catch(function(error) {
          vue.creando = false;
        });
    }
  },
  computed: {
    classType: function() {
      var success =
        this.dataCrear.type == "success"
          ? "text-success border border-success"
          : "";
      var error =
        this.dataCrear.type == "error"
          ? "text-danger border border-danger"
          : "";
      var info =
        this.dataCrear.type == "info" ? "text-info border border-info" : "";
      var warning =
        this.dataCrear.type == "warning"
          ? "text-warning border border-warning"
          : "";

      var clase = `${success} ${error} ${info} ${warning}`;

      return clase;
    }
  },
  mounted: function() {
    if (this.avisos.length == 0) {
      this.getAvisos();
    }
  },
  created() {},

  template: `

  <div  v-if="avisos.length > 0" class="col-12 mb-3">
    <div class="w-100">
       <aviso-item @actualizar="getAvisos"  :admin="admin" v-for="aviso in avisos" :aviso="aviso" :key="aviso.id"></aviso-item>
    </div>
  </div>

`
});
