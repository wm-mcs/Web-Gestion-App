var ServiciosVendidos = {
  mixins: [misChartMixin, orderFunction],
  components: {
    "bar-chart": barChart
  },
  data: function() {
    return {
      cargando: false,
      fecha_inicio: null,
      fecha_fin: null,
      servicios: [],

      datos: [],
      chartData: {
        labels: null,
        datasets: []
      }
    };
  },

  created: function() {
    this.getData();

    bus.$on("cambio-perido", (data) => {
      this.fecha_inicio = data.fecha_inicio;
      this.fecha_fin = data.fecha_fin;

      console.log(data);

      this.getData();
    });
  },

  mounted: function mounted() {},

  methods: {
    getData: function() {
      let url = "/get_servicios_vendidos";
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
            vue.servicios = response.data.Data.Servicios;
            vue.fecha_inicio = response.data.Data.fecha_inicio;
            vue.fecha_fin = response.data.Data.fecha_fin;
            $.notify(response.data.Validacion_mensaje, "success");
          } else {
            vue.cargando = false;
            $.notify(response.data.Validacion_mensaje, "error");
          }
        })
        .then(function() {
          vue.setData();
        })

        .catch(function(error) {
          vue.cargando = false;
          $.notify(error.message, "error");
        });
    },

    setData: function() {
      this.recetChartData();

      const serviciosDelPeriodo = this.servicios;

      const dataset = this.setDataSet("");

      const tipoDeServicios = this.$root.empresa.tipo_servicios.sort(
        this.compareValues("name", "asc")
      );

      tipoDeServicios.forEach((tipo) => {
        const cantidadRegistrosDeEsteTipo = serviciosDelPeriodo.filter(
          (servicio) => {
            return parseInt(servicio.tipo_servicio_id) === parseInt(tipo.id);
          }
        );

        if (cantidadRegistrosDeEsteTipo.length > 0) {
          this.chartData.labels.push(`${tipo.name}`);

          dataset.backgroundColor.push(this.colorBlue);
          dataset.label = "";

          dataset.data.push(cantidadRegistrosDeEsteTipo.length);
        }
      });

      this.chartData.datasets.push(dataset);
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
    <strong>Servicios vendidos del período @{{fecha_inicio}} || @{{fecha_fin}}</strong>
    </h6>

      <div class="row mb-4 mx-0">

		<p class="col-12 mt-2">
			<small>
				Los resultados que estás viendo son los del período <b>@{{fecha_inicio}} al @{{fecha_fin}}</b>. Puedes cambiar las fechas a tu gusta y se graficará los movimientos entre las fechas que tu indiques.
			</small>

		</p>
      </div>



	  <div class="w-100" v-if="servicios.length">



       <div class="col-12">
      <p class=""><b>Cantidad de servicios vendidos deslosados</b></p>

        <bar-chart :chart-data="chartData" ></bar-chart>
      </div>

	  </div>

	  <div v-else class="h4 my-5 color-text-gris text-center"> 🤔 No hay movimientos en el período del <b>@{{fecha_inicio}} al @{{fecha_fin}}.</b>  Probá cambiando las fechas. </div>

    </div>




</div>
    `
};
