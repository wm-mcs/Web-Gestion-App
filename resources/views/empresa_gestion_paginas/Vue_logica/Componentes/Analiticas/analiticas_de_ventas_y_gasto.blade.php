Vue.component("analiticas-de-ventas-y-gasto", {
	data: function() {
		return {
			cargando: false,
			fecha_inicio: null,
			fecha_fin: null,
			movimientos: []
		};
	},

	mounted: function mounted() {
		this.getData()
			.then(function() {
				console.log("Se terminaron de cargar los datos");
			})
			.then(function() {
				console.log("Se terminaron de cargar los datos 2");
			});
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

			console.log(vue);

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
		<div class="admin-user-boton-Crear" v-on:click="getData()"><i class="fas fa-search"></i> </div>
		</div>
        </div>

        <p v-if="movimientos.length" v-for="movimiento in movimientos" :key="movimiento.id">@{{movimiento.id}}</p>
        </div>
    `
});
