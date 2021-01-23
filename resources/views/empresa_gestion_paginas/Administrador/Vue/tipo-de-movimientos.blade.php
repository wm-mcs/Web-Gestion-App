Vue.component("tipo-de-movimientos", {
	data: function () {
		return {
			tipo_de_movimientos: [],
			cargando: false
		};
	},
	methods: {
		get_tipo_de_movimientos: function () {
			let url = "/get_tipo_de_movimientos";
			let vue = this;

			this.cargando = true;

			axios
				.get(url)
				.then(function (response) {
					let data = response.data;

					if (data.Validacion == true) {
						vue.cargando = false;
						vue.tipo_de_movimientos = response.data.Tipo_de_movimientos;
						$.notify(response.data.Validacion_mensaje, "success");
					} else {
						vue.cargando = false;
						$.notify(response.data.Validacion_mensaje, "error");
					}
				})
				.catch(function (error) {
					vue.cargando = false;
					$.notify(error, "error");
				});
		}
	},
	computed: {
		get_movimientos_a_socios: function () {
			return this.tipo_de_movimientos.filter(
				tipo => tipo.movimiento_de_empresa_a_socio == "si"
			);
		},
		get_movimientos_a_empresa: function () {
			return this.tipo_de_movimientos.filter(
				tipo => tipo.movimiento_de_la_empresa == "si"
			);
		}
	},
	mounted: function () {
		this.get_tipo_de_movimientos();
	},
	created() {
		bus.$on("se-creo-un-movimiento", data => {
			this.get_tipo_de_movimientos();
		});
	},

	template: `
<div  v-if="cargando" class="w-100 d-flex flex-column align-items-center p-5">
   <div class="cssload-container">
       <div class="cssload-tube-tunnel"></div>
   </div>
</div>
<div v-else class="p-5">
	<div v-if="get_movimientos_a_empresa.length" class="row mb-4 p-2 ">
    <h2 class="col-12 mb-4 parrafo-class color-text-gris"><b>Tipo de movimientos de la empresa</b></h2>
		<tipo_de_movimiento_lista 
     v-for="tipo_movimiento in get_movimientos_a_empresa"
     :tipo_de_movimiento="tipo_movimiento"
     :key="tipo_movimiento.id"
    ></tipo_de_movimiento_lista>
	</div>
  <div v-else class="text-center sub-titulos-class color-text-gris" >Aún no hay tipos de movimientos para la empresa.</div>
  <div v-if="get_movimientos_a_socios.length" class="row mb-0 p-2 ">
    <h2 class="col-12 mb-4 parrafo-class color-text-gris"><b>Tipo de movimientos de los socios</b></h2>
    <tipo_de_movimiento_lista 
     v-for="tipo_movimiento in get_movimientos_a_socios"
     :tipo_de_movimiento="tipo_movimiento"
     :key="tipo_movimiento.id"
    ></tipo_de_movimiento_lista>
  </div>
	<div v-else class="text-center sub-titulos-class color-text-gris" >Aún no hay tipos de movimientos para los socios.</div>
</div>
`
});
