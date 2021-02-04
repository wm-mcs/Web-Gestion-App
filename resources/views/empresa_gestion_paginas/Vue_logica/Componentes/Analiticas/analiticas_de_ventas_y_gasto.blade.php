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
        },
        responsive: true,
        maintainAspectRatio: false
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
        labels: null,
        datasets: []
      }
    };
  },

  created: function() {
    this.getData();
  },

  mounted: function mounted() {
    this.setData();
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
            backgroundColor: [],
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
              (tipo) => {
                return tipo.movimiento_de_la_empresa == "si";
              }
            );
            vue.setData();

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
    recetChartData: function() {
      this.chartData = {
        labels: [],
        datasets: [
          {
            label: "",
            backgroundColor: [],
            data: []
          }
        ]
      };
    },
    setData: function() {
      this.recetChartData();
      let cantidadRegistrosDeEsteTipo = "";
      this.tipo_de_movimientos.forEach((tipo) => {
        cantidadRegistrosDeEsteTipo = this.movimientos.filter(
          (movimiento) =>
            parseInt(movimiento.tipo_de_movimiento_id) === parseInt(tipo.id)
        );

        console.log(cantidadRegistrosDeEsteTipo, "Id", tipo);

        if (cantidadRegistrosDeEsteTipo.length) {
          this.chartData.labels.push(tipo.name);

          if (this.chartData.datasets.length === 1) {
            let dataset = this.chartData.datasets[0];

            dataset.label = `Periodo ${this.fecha_inicio} a ${this.fecha_fin}`;
            dataset.backgroundColor.push(
              this.esSaldoDeudor(tipo) ? "#4bb543" : " #fcb6b6"
            );

            dataset.data.push(
              this.calcularSaldo(
                this.esSaldoDeudor(tipo),
                cantidadRegistrosDeEsteTipo
              )
            );
          }
        }
      });
    },
    esSaldoDeudor: function(tipo) {
      return tipo.tipo_saldo === "deudor" ? treu : false;
    },
    calcularSaldo: function(esDeudor, data) {
      let REDUCER = (acc, movimiento) => acc + parseFloat(movimiento.valor);
      let deduroSumados = data
        .filter((movimiento) => movimiento.tipo_saldo == "deudor")
        .reduce(REDUCER, 0);
      let acredorSumados = data
        .filter((movimiento) => movimiento.tipo_saldo == "acredor")
        .reduce(REDUCER, 0);

      return esDeudor
        ? deduroSumados - acredorSumados
        : acredorSumados - deduroSumados;
    }
  },
  computed: {},

  template: `

  <div v-if="cargando">Cargando</div>
  <div v-else>
        
    <div class="fechas-buscar-texto">
			Filtrar movimientos entre fechas. Para hacer arqueos elegir la misma fecha en ambos campos. De esa manera se verán los movimientos de ese día y el saldo a ese día.
		</div>
		<div class="get_width_100 flex-row-center">
			<div class="flex-row-column">
        <input type="date" class="form-control fecha_input_caja_busqueda" v-model="fecha_inicio" name="">
        <input type="date" class="form-control fecha_input_caja_busqueda" v-model="fecha_fin" name="">
      </div>
		</div>
    <div class="admin-user-boton-Crear" v-on:click="getData">
      <i class="fas fa-search"></i> 
    </div>
	
    <div class="col-12 p-3 p-lg-5">
      <line-chart :chart-data="chartData" ></line-chart>
    </div>
	

        <p v-if="movimientos.length" v-for="movimiento in movimientos" :key="movimiento.id">@{{movimiento.id}}</p>
</div>
    `
});
