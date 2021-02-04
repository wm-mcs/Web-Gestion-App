const lineChart = {
	extends: VueChartJs.Bar,
	mixins: [VueChartJs.reactiveProp],
	props: ["datasets", "labels"],

	mounted() {
		this.renderChart(
			{
				labels: this.labels,
				datasets: this.datasets
			},
			{
				scales: {
					yAxes: [
						{
							ticks: {
								beginAtZero: true
							},
							gridLines: {
								display: true
							}
						}
					],
					xAxes: [
						{
							ticks: {
								beginAtZero: true
							},
							gridLines: {
								display: true
							}
						}
					]
				},
				legend: {
					display: true
				},
				tooltips: {
					enabled: true,
					mode: "single",
					callbacks: {
						label: function(tooltipItems, data) {
							return "$ sdf " + tooltipItems.yLabel;
						}
					}
				},
				responsive: true,
				maintainAspectRatio: false,
				height: 200
			}
		);
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
			labels: ["January", "February", "March", "April", "May", "June", "July"],
			datasets: [
				{
					label: "Data One",
					backgroundColor: "#f87979",
					borderWidth: 1,
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
		};
	},

	mounted: function mounted() {
		this.getData();
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
							tipo => tipo.movimiento_de_la_empresa == "si"
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
		<line-chart :datasets="datasets" :labels="labels"></line-chart>

        <p v-if="movimientos.length" v-for="movimiento in movimientos" :key="movimiento.id">@{{movimiento.id}}</p>
        </div>
    `
});
