@include('empresa_gestion_paginas.Administrador.Vue.Planes.plan')

Vue.component("listado-de-paises", {
  components: {
    plan: plan
  },
  data: function() {
    return {
      planes: [],
      cargando: false
    };
  },
  methods: {
    getPlanes: function() {
      var url = "/get_paises_todos";
      var vue = this;
      vue.cargando = true;
      axios
        .get(url)
        .then(function(response) {
          var data = response.data;

          if (data.Validacion == true) {
            vue.planes = data.Data;
            $.notify(response.data.Validacion_mensaje, "success");
            vue.cargando = false;
          } else {
            $.notify(response.data.Validacion_mensaje, "error");
            vue.cargando = false;
          }
        })
        .catch(function(error) {
          vue.cargando = false;
        });
    }
  },
  computed: {},
  mounted: function() {
    this.getPlanes();
  },
  created() {
    bus.$on("se-creo-o-edito-un-plan", (data) => {
      this.getPlanes();
    });
  },

  template: `
	<div v-if="cargando" class="w-100 d-flex flex-column align-items-center p-5">
        <div class="cssload-container">
            <div class="cssload-tube-tunnel"></div>
        </div>
    </div>
    <div v-else class="p-5">
        <div v-if="planes.length" class="row mb-4 p-2 ">
            <plan v-for="plan in planes" :pais="plan" :key="plan.id"></plan>
        </div>

    </div>
`
});
