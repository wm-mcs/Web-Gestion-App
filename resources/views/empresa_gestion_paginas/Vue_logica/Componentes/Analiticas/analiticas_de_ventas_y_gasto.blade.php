Vue.component("analiticas-de-ventas-y-gasto", {
	data: function() {
		return {
			cargando: false,
			fecha_inicio: null,
			fecha_fin: null,
			movimientos: [],
			tipo_de_movimientos: [],
			datos: []
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
		calcularSaldo: function() {},
		graficar: function() {
			const data = {
				labels: [
					"12am-3am",
					"3am-6pm",
					"6am-9am",
					"9am-12am",
					"12pm-3pm",
					"3pm-6pm",
					"6pm-9pm",
					"9am-12am"
				],
				datasets: [
					{
						name: "Some Data",
						type: "bar",
						values: [25, 40, 30, 35, 8, 52, 17, -4]
					},
					{
						name: "Another Set",
						type: "line",
						values: [25, 50, -10, 15, 18, 32, 27, 14]
					}
				]
			};

			const chart = new frappe.Chart("#grafica", {
				// or a DOM element,
				// new Chart() in case of ES6 module with above usage
				title: "My Awesome Chart",
				data: data,
				type: "axis-mixed", // or 'bar', 'line', 'scatter', 'pie', 'percentage'
				height: 250,
				colors: ["#7cd6fd", "#743ee2"]
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
		<div class="admin-user-boton-Crear" v-on:click="getData()"><i class="fas fa-search"></i> </div>
		</div>
		</div>
		<div id="grafica">
		</div>

        <p v-if="movimientos.length" v-for="movimiento in movimientos" :key="movimiento.id">@{{movimiento.id}}</p>
        </div>
    `
});
