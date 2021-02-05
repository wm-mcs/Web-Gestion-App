const misChartMixin = {
  methods: {
    recetChartData: function() {
      this.chartData = {
        labels: [],
        datasets: []
      };
    },
    setDataSet: function(label, backgroundColor = [], data = []) {
      return {
        label: label,
        backgroundColor: backgroundColor,
        data: data
      };
    },
    setData: function() {
      this.recetChartData();

      const movimientosDelPeriodo = this.movimientos;
      const dataset = this.setDataSet();

      this.tipo_de_movimientos.forEach((tipo) => {
        console.log(this.movimientos);
        const cantidadRegistrosDeEsteTipo = movimientosDelPeriodo.filter(
          (movimiento) =>
            parseInt(movimiento.tipo_de_movimiento_id) === parseInt(tipo.id)
        );

        if (cantidadRegistrosDeEsteTipo.length) {
          this.chartData.labels.push(tipo.name);

          dataset.label = `Periodo ${this.fecha_inicio} a ${this.fecha_fin}`;
          dataset.backgroundColor.push(
            tipo.tipo_saldo == "deudor" ? "#4bb543" : " #fcb6b6"
          );

          dataset.data.push(
            this.calcularSaldo(
              tipo.tipo_saldo == "deudor" ? true : false,
              cantidadRegistrosDeEsteTipo
            )
          );
        }
      });

      this.chartData.datasets.push(dataset);
    },

    calcularSaldo: function(esDeudor, data) {
      let REDUCER = (acc, movimiento) =>
        parseFloat(acc) + parseFloat(movimiento.valor);
      let deduroSumados = data
        .filter((movimiento) => movimiento.tipo_saldo === "deudor")
        .reduce(REDUCER, 0);
      let acredorSumados = data
        .filter((movimiento) => movimiento.tipo_saldo === "acredor")
        .reduce(REDUCER, 0);

      return esDeudor
        ? deduroSumados - acredorSumados
        : acredorSumados - deduroSumados;
    }
  }
};

const barChart = {
  extends: VueChartJs.Bar,
  mixins: [VueChartJs.mixins.reactiveProp],

  data: function() {
    return {
      options: {
        responsive: true,
        maintainAspectRatio: false
      }
    };
  },

  mounted() {
    this.renderChart(this.chartData, this.options);
  }
};

Vue.component("ventas-gastos-segun-periodo", {
  mixins: [misChartMixin],
  components: {
    "bar-chart": barChart
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
            vue.tipo_de_movimientos = response.data.Tipo_de_movimientos;
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
    }
  },
  computed: {},

  template: `

  <div v-if="cargando" class="Procesando-text w-100 p-4 text-center">
                        Procesando...
  </div>
  <div v-else class="mb-3">

    <div class="contenedor-grupo-datos w-100">

    <h5 class="col-12" >
    <strong>Movimientos del periodo @{{fecha_inicio}} || @{{fecha_fin}}</strong>
    </h5>

      <div class="row mb-2">
        <div class="p-2 col-12 col-lg-8 row mx-0 mb-2 mb-lg-0">
          <div class="col-6">
            <input type="date" class="formulario-field" v-model="fecha_inicio" name="">
          </div>
          <div class="col-6">
            <input type="date" class="formulario-field" v-model="fecha_fin" name="">
          </div>
        </div>
        <div class="p-2  col-12 col-lg-4 row mx-0 ">
          <div  v-on:click="getData" class=" admin-user-boton-Crear">
            <i class="fas fa-search"></i>
          </div>
        </div>
      </div>

	    <h5 class="col-12 mb-3" >Movimientos del periodo @{{fecha_inicio}} || @{{fecha_fin}}</h5>
      <div class="col-12">
         <bar-chart :chart-data="chartData" ></bar-chart>
      </div>

    </div>



</div>
    `
});
