Vue.component("crear-plan", {
	data: function() {
		return {
			cargando: false,
			datos_a_enviar: {
				name: "",
				cantidad_socios: "",
				cantidad_sucursales: "",
				valor: "",
				moneda: "",
				valor_fuera_de_uruguay: "",
				estado: "",
				control_acceso: "",
        reserva_de_clases_on_line:"",
				tipo: "principal"
			},
			showModal: false
		};
	},
	methods: {
		limpiar_data_crear: function() {
			this.datos_a_enviar = {
				name: "",
				cantidad_socios: "",
				cantidad_sucursales: "",
				valor: "",
				moneda: "",
				valor_fuera_de_uruguay: "",
				estado: "",
				control_acceso: ""
			};
		},

		crear: function() {
			var url = "/crear_plan";

			var data = this.datos_a_enviar;

			var vue = this;

			axios
				.post(url, data)
				.then(function(response) {
					var data = response.data;

					if (data.Validacion == true) {
						vue.cargando = false;
						bus.$emit("se-creo-o-edito-un-plan", "hola");
						vue.showModal = false;
						vue.limpiar_data_crear();
						$.notify(response.data.Validacion_mensaje, "success");
					} else {
						vue.cargando = false;
						$.notify(response.data.Validacion_mensaje, "error");
					}
				})
				.catch(function(error) {
					vue.cargando = false;
					$.notify("Upsssssss.. algo pasó", "error");
				});
		}
	},
	computed: {},
	mounted: function() {},

	template: `<span>


  <div class="Boton-Fuente-Chica Boton-Primario-Relleno " @click="showModal = true">
   Crear plan <i class="fas fa-plus"></i>
  </div>


  <transition name="modal" v-if="showModal">
    <div class="modal-mask ">
      <div class="modal-wrapper">
        <div class="modal-container position-relative">
        <span class="modal-cerrar-icono sub-titulos-class text-center color-text-gris" @click="showModal = !showModal">
          <i class="fas fa-times"></i>
        </span>


          <div class="row">
            <h4 class="col-12 sub-titulos-class" > Crear país</h4>
            <div class="col-12 modal-mensaje-aclarador">

            </div>
          </div>

          <div class="modal-body">

              <div class="row mx-0 contenedor-grupo-datos">





                  <div class="col-lg-6 formulario-label-fiel">
                    <label class="formulario-label">Nombre </label>
                    <input type="text" class="formulario-field" v-model="datos_a_enviar.name" placeholder="Nombre del plan" />
                  </div>

                   <div class="col-lg-6 formulario-label-fiel">
                    <label class="formulario-label">Tipo </label>
                    <div class="formulario-label-aclaracion">
                       Atributo que distingue un plan completo con un upgrade. Actualmente solo se usa de tipo principal.
                    </div>
                    <input type="text" class="formulario-field" v-model="datos_a_enviar.tipo" placeholder="Tipo de plan" />
                  </div>

                  <div class="col-lg-6 formulario-label-fiel">
                    <label class="formulario-label">Cantidad de socios </label>
                    <input type="text" class="formulario-field" v-model="datos_a_enviar.cantidad_socios " placeholder="Cantidad de socios" />
                  </div>

                  <div class="col-lg-6 formulario-label-fiel">
                    <label class="formulario-label">Cantidad de sucursales </label>
                    <input type="text" class="formulario-field" v-model="datos_a_enviar.cantidad_sucursales " placeholder="Cantidad de sucursales" />
                  </div>

                  <div class="col-lg-6 formulario-label-fiel">
                    <label class="formulario-label">Precio en $ Uruguayos </label>
                    <div class="formulario-label-aclaracion">
                    Es el precio sin impuestos en pesos. Para el caso de Uruguay.
                  </div>
                    <input type="text" class="formulario-field" v-model="datos_a_enviar.valor" placeholder="Precio" />
                  </div>

                  <div class="col-6 formulario-label-fiel">
                    <label class="formulario-label">¿Moneda en Uruguay?</label>
                    <div class="formulario-label-aclaracion">
                       Es la moneda que se usa para cobrar en Uruguay. Puede ser pesos o dolares.
                    </div>
                    <select v-model="datos_a_enviar.moneda" class="formulario-field">
                        <option>$</option>
                        <option>U$S</option>
                    </select>
                  </div>



                  <div class="col-lg-6 formulario-label-fiel">
                    <label class="formulario-label">Precio fuera de uruguay  </label>
                    <div class="formulario-label-aclaracion">
                    Este valor será en DOLARES.
                  </div>
                    <input type="text" class="formulario-field" v-model="datos_a_enviar.valor_fuera_de_uruguay" placeholder="Precio fuera de Uruguay" />
                  </div>





                  <div class="col-6 formulario-label-fiel">
                    <label class="formulario-label">¿Activo?</label>
                    <select v-model="datos_a_enviar.estado" class="formulario-field">
                        <option>si</option>
                        <option>no</option>
                    </select>
                  </div>









                </div>
                <div class="row mx-0 contenedor-grupo-datos">
                <div class="col-6 formulario-label-fiel">
                    <label class="formulario-label">¿Incluye control de acceso? </label>
                    <select v-model="datos_a_enviar.control_acceso" class="formulario-field">
                        <option>si</option>
                        <option>no</option>
                    </select>
                  </div>
                </div>

                <div class="row mx-0 contenedor-grupo-datos">
                <div class="col-6 formulario-label-fiel">
                    <label class="formulario-label">¿Incluye reserva de clases online? </label>
                    <select v-model="datos_a_enviar.reserva_de_clases_on_line" class="formulario-field">
                        <option>si</option>
                        <option>no</option>
                    </select>
                  </div>
                </div>






                  <div @click="crear" class="mt-4 Boton-Fuente-Chica Boton-Primario-Sin-Relleno">
                    Confirmar
                  </div>






          </div>

          <div class="modal-footer">

              <button class="modal-default-button" @click="showModal = false" >
                Cancelar
              </button>

          </div>
        </div>
      </div>
    </div>
  </transition>
</span>

`
});
