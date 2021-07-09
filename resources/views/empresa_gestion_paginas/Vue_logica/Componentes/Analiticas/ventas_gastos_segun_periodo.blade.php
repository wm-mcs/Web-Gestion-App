var VentasGastoSegunPeridodo = {
  mixins: [misChartMixin, orderFunction],
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
      },
      chartDataAgrupado: {
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
            bus.$emit("cambio-perido", {
              fecha_inicio:response.data.Data.fecha_inicio,
              fecha_fin: response.data.Data.fecha_fin
            });

            console.log(response.data.Data.fecha_inicio,response.data.Data.fecha_inicio);
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
    },
    setData: function() {
      this.recetChartData();

      const movimientosDelPeriodo = this.movimientos;
      const dataset = this.setDataSet("");

      this.tipo_de_movimientos
        .sort(this.compareValues("tipo_saldo", "desc"))
        .forEach((tipo) => {
          const cantidadRegistrosDeEsteTipo = movimientosDelPeriodo.filter(
            (movimiento) =>
              parseInt(movimiento.tipo_de_movimiento_id) === parseInt(tipo.id)
          );

          if (cantidadRegistrosDeEsteTipo.length) {
            let saldo = this.calcularSaldo(
              tipo.tipo_saldo == "deudor" ? true : false,
              cantidadRegistrosDeEsteTipo
            );
            if (saldo > 0) {
              this.chartData.labels.push(tipo.name);

              dataset.backgroundColor.push(
                tipo.tipo_saldo == "deudor"
                  ? this.colorSuccess
                  : this.colorDanger
              );
              dataset.label = "";

              dataset.data.push(saldo);
            }
          }
        });

      this.chartData.datasets.push(dataset);
      this.setDataAgrupada();
    },
    setDataAgrupada: function() {
      const movimientosDelPeriodo = this.movimientos;

      this.chartDataAgrupado.labels = ["ingresos", "gastos"];

      const dataset = this.setDataSet("");

      dataset.backgroundColor = [this.colorSuccess, this.colorDanger];

      let saldoDeudor = 0;

      let saldoAcredor = 0;

      this.tipo_de_movimientos
        .sort(this.compareValues("tipo_saldo", "desc"))
        .forEach((tipo) => {
          const cantidadRegistrosDeEsteTipo = movimientosDelPeriodo.filter(
            (movimiento) =>
              parseInt(movimiento.tipo_de_movimiento_id) === parseInt(tipo.id)
          );

          if (cantidadRegistrosDeEsteTipo.length) {
            let saldo = this.calcularSaldo(
              tipo.tipo_saldo == "deudor" ? true : false,
              cantidadRegistrosDeEsteTipo
            );
            if (saldo > 0) {
              tipo.tipo_saldo == "deudor"
                ? (saldoDeudor += saldo)
                : (saldoAcredor += saldo);
            }
          }
        });

      dataset.data = [saldoDeudor, saldoAcredor];

      this.chartDataAgrupado.datasets = [];
      this.chartDataAgrupado.datasets.push(dataset);
    }
  },
  computed: {},

  template: `

  <div v-if="cargando" class="Procesando-text w-100 p-4 text-center">
                        Procesando...
  </div>
  <div v-else class="mb-3">

    <div  class="contenedor-grupo-datos w-100">

    <h6 class="col-12 mb-3" >
    <strong>Entrada y salida de dinero del periódo @{{fecha_inicio}} || @{{fecha_fin}}</strong>
    </h6>

      <div class="row mb-4 mx-0">
        <div class="p-0 col-12 col-lg-8 row mx-0 mb-2 mb-lg-0">
          <div class="col-6">
            <input type="date" class="formulario-field" v-model="fecha_inicio" name="">
          </div>
          <div class="col-6">
            <input type="date" class="formulario-field" v-model="fecha_fin" name="">
          </div>
        </div>
        <div class="col-12 col-lg-4 row mx-0 ">
          <div  v-on:click="getData" class=" admin-user-boton-Crear">
            <i class="fas fa-search"></i>
          </div>
        </div>
		<p class="col-12 mt-2">
			<small>
				Los resultados que estás viendo son los del período <b>@{{fecha_inicio}} al @{{fecha_fin}}</b>. Puedes cambiar las fechas a tu gusta y se graficará los movimientos entre las fechas que tu indiques.
			</small>

		</p>
      </div>



	  <div class="w-100" v-if="movimientos.length">


       <div class="col-12 mb-4">
           <p class=""><b>Ingresos y salidas de dinero en $ </b></p>
         <bar-chart :chart-data="chartDataAgrupado" ></bar-chart>
      </div>

       <div class="col-12">
      <p class=""><b>Datos desglosados por tipo </b></p>

        <bar-chart :chart-data="chartData" ></bar-chart>
      </div>

	  </div>

	  <div v-else class="h4 my-5 color-text-gris text-center"> 🤔 No hay movimientos en el período del <b>@{{fecha_inicio}} al @{{fecha_fin}}.</b>  Probá cambiando las fechas. </div>

    </div>




</div>
    `
};
