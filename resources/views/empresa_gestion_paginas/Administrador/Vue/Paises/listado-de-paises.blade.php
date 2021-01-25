@include('empresa_gestion_paginas.Administrador.Vue.Paises.pais')

Vue.component("listado-de-paises", {

	components :{
		'pais':pais
	},
	data: function() {
		return {
			paises: [],
			cargando: false
		};
	},
	methods: {
		getPaises: function() {
			var url = "/get_paises";
			var vue = this;

			axios
				.get(url)
				.then(function(response) {
					var data = response.data;

					if (data.Validacion == true) {
						vue.paises = data.Paises;
						$.notify(response.data.Validacion_mensaje, "success");
					} else {
						$.notify(response.data.Validacion_mensaje, "error");
					}
				})
				.catch(function(error) {});
		}
	},
	computed: {
		
	},
	mounted: function() {
		this.getPaises();
	},
	created() {
		bus.$on("se-creo-o-edito-pais", data => {
			this.getPaises();
		});
	},

	template: `
	<div v-if="cargando" class="w-100 d-flex flex-column align-items-center p-5">
		<div class="cssload-container">
			<div class="cssload-tube-tunnel"></div>
		</div>
	</div>
	<div v-else class="p-5">
		<div v-if="paises.length" class="row mb-4 p-2 ">
			<pais v-for="pais in paises" :pais="pais" :key="pais.id"></pais>
		</div>

	</div>
`
});
