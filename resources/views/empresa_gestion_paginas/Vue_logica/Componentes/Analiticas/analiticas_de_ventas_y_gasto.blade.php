const lineChart = {
  extends: VueChartJs.Bar,
  mixins: [VueChartJs.mixins.reactiveProp],

  data: function() {
    return {
      options: {
        scales: {
          xAxes: [
            {
              gridLines: {
                offsetGridLines: true
              }
            }
          ],
          yAxes: [
            {
              ticks: {
                beginAtZero: true
              }
            }
          ]
        }
      }
    };
  },

  mounted() {
    this.renderChart(this.chartData, this.options);
  }
};

Vue.component("analiticas-de-ventas-y-gasto", {
  components: {
    "line-chart": lineChart
  },
  data: function() {
    return {
      cargando: false,
      fecha_inicio: null,
      fecha_fin: null,
      movimientos: [],
      tipo_de_movimientos: [],
      datos: [],

      chartData: {
        labels: [
          "January",
          "February",
          "March",
          "April",
          "May",
          "June",
          "July"
        ],
        datasets: [
          {
            barPercentage: 0.5,
            barThickness: 6,
            maxBarThickness: 8,
            minBarLength: 2,
            pointBorderColor: "#249EBF",

            data: [40, 39, 10, 40, 39, 80, 40]
          },
          {
            label: "Data two",
            backgroundColor: "#f8re79",
            borderWidth: 1,
            pointBorderColor: "#249EBF",

            data: [40, 39, 10, 40, 39, 80, 40]
          }
        ]
      }
    };
  },

  mounted: function mounted() {
    this.getData();
    setInterval(this.generateData, 2000);
  },

  methods: {
    generateData() {
      let newArray = [];
      for (let i = 0; i < 10; i++) {
        let randomValue = Math.floor(Math.random() * 10);
        newArray.push(randomValue);
      }

      this.chartData = {
        labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
        datasets: [
          {
            label: "Data One",
            backgroundColor: "#f87979",
            data: newArray
          }
        ]
      };
    },
    getData: function() {
      let url = "/get_movimientos_de_caja_para_analiticas";
      let vue = this;
      this.cargando = true;

      let data = {
        fecha_inicio: this.fecha_inicio,
        fecha_fin: this.fecha_fin,
        empresa_id: this.$root.empresa.id
      };

      return axios
        .post(url, data)
        .then(function(response) {
          if (response.data.Validacion == true) {
            vue.cargando = false;
            vue.movimientos = response.data.Data.Movimientos;
            vue.fecha_inicio = response.data.Data.fecha_inicio;
            vue.fecha_fin = response.data.Data.fecha_fin;
            $.notify(response.data.Validacion_mensaje, "success");
          } else {
            vue.cargando = false;
            $.notify(response.data.Validacion_mensaje, "error");
          }
        })
        .then(function() {
          vue.getTipoDeMovimientos();
        })
        .then(function() {
          console.log("Se terminaron de cargar los datos 2");
        })
        .catch(function(error) {
          vue.cargando = false;
          $.notify(error.message, "error");
        });
    },
    getTipoDeMovimientos: function() {
      let url = "/get_tipo_de_movimientos";
      let vue = this;
      this.cargando = true;
      return axios
        .get(url)
        .then(function(response) {
          if (response.data.Validacion == true) {
            vue.cargando = false;
            vue.tipo_de_movimientos = response.data.Tipo_de_movimientos.filter(
              (tipo) => tipo.movimiento_de_la_empresa == "si"
            );

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
    },
    setData: function() {},
    calcularSaldo: function() {}
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
    <div class="col-12 p-3 p-lg-5">
    <line-chart :chart-data="chartData" ></line-chart>
    </div>
	

        <p v-if="movimientos.length" v-for="movimiento in movimientos" :key="movimiento.id">@{{movimiento.id}}</p>
        </div>
    `
});
