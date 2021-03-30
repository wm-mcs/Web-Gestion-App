const actividadeslMixIn = {
  data: function () {
    return {
      actividades: [],
    };
  },
  methods: {
    getActividades: function () {
      var url = "/get_actividad";

      var data = { empresa_id: this.$root.empresa.id };

      var vue = this;
      vue.cargando = true;

      axios
        .post(url, data)
        .then(function (response) {
          var data = response.data;

          if (data.Validacion == true) {
            vue.cargando = false;
            vue.actividades = data.Data;
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
    this.getActividades();
  },
};
