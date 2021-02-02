Vue.component("analiticas-de-ventas-y-gasto", {
  props: ["empresa"],
  data: function() {
    return {
      cargando: false,
      fecha_inicial: new Date(),
      fecha_final: new Date(),
      data: []
    };
  },

  mounted() {
    this.getData();
  },

  methods: {
    getData: function() {
      let url = "/get_movimientos_de_caja_para_analiticas";
      let vue = this;
      this.cargando = true;

      let data = {
        fecha_inicial: this.fecha_inicial,
        fecha_final: this.fecha_final,
        empresa_id: this.$root.empresa.id
      };

      axios
        .post(url, data)
        .then(function(response) {
          if (response.data.Validacion == true) {
            vue.cargando = false;
            vue.data = response.data.Data.Movimientos;
            $.notify(response.data.Validacion_mensaje, "success");
          } else {
            vue.cargando = false;
            $.notify(response.data.Validacion_mensaje, "error");
          }
        })
        .catch(function(error) {
          vue.cargando = false;
          $.notify(error.message, "error");
        });
    }
  },
  computed: {},

  template: `


  <div>
        <div>
            <div class="fechas-buscar-texto">
			Filtrar movimientos entre fechas. Para hacer arqueos elegir la misma fecha en ambos campos. De esa manera se verán los movimientos de ese día y el saldo a ese día.
		</div>
		<div class="get_width_100 flex-row-center">
			<div class="flex-row-column">
			<input type="date" class="form-control fecha_input_caja_busqueda" v-model="fecha_inicio" name="">
			<input type="date" class="form-control fecha_input_caja_busqueda" v-model="fecha_fin" name="">
		</div>
		<div class="admin-user-boton-Crear" v-on:click="getData"><i class="fas fa-search"></i> </div>
		</div>
        </div>

        <p v-if="Data.length" v-for="movimiento in Data" :key="movimiento.id">@{{movimiento.id}}</p>
        </div>    
    `
});
