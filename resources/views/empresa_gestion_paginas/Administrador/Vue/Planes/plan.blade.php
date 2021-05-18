var plan = {
	props: ["plan"],
	data: function() {
		return {
			cargando: false,
			showModal: false,
			imagen: ""
		};
	},
	methods: {
		editarPlan: function() {
			var url = "/editar_plan_empresa";

			var data = { plan: this.plan };
			var vue = this;

			axios
				.post(url, data)
				.then(function(response) {
					var data = response.data;

					if (data.Validacion == true) {
            bus.$emit("se-creo-o-edito-un-plan", "hola");
						$.notify(response.data.Validacion_mensaje, "success");
					} else {
						$.notify(response.data.Validacion_mensaje, "error");
					}
				})
				.catch(function(error) {});
		}
	},
	template: `
  <div class="col-6 col-lg-4 p-1 ">
    <div class="p-3  border-radius-estandar borde-gris background-white h-100">
      <div class="row mx-0 align-items-center">

        <div class="col-12 mb-0   cursor-pointer" @click="showModal = true">
        <p class="h5 mb-1"><b>@{{plan.name}}</b></p>


          <p  class="mb-0" :class="plan.estado === 'si' ? 'color-text-success' : 'color-text-gris'"> @{{ plan.estado === 'si' ? 'Activo':'Desactivado'}}
        </p>
        </div>


      </div>

      <transition name="modal" v-if="showModal">
        <div class="modal-mask ">
          <div class="modal-wrapper">
            <div class="modal-container position-relative">
              <span class="modal-cerrar-icono sub-titulos-class text-center color-text-gris"
                @click="showModal = !showModal">
                <i class="fas fa-times"></i>
              </span>


              <div class="row">
                <h4 class="col-12 sub-titulos-class"> Editar @{{plan.name}}</h4>
                <div class="col-12 modal-mensaje-aclarador">
                  Editar los datos correspondientes al plan <b>@{{plan.name}}</b>.
                </div>
              </div>

              <div class="modal-body">

                <div class="row mx-0 contenedor-grupo-datos">





                  <div class="col-lg-6 formulario-label-fiel">
                    <label class="formulario-label">Nombre </label>
                    <input type="text" class="formulario-field" v-model="plan.name" placeholder="Nombre del plan" />
                  </div>

                  <div class="col-lg-6 formulario-label-fiel">
                    <label class="formulario-label">Cantidad de socios </label>
                    <input type="text" class="formulario-field" v-model="plan.cantidad_socios " placeholder="Cantidad de socios" />
                  </div>

                  <div class="col-lg-6 formulario-label-fiel">
                    <label class="formulario-label">Cantidad de sucursales </label>
                    <input type="text" class="formulario-field" v-model="plan.cantidad_sucursales " placeholder="Cantidad de sucursales" />
                  </div>

                  <div class="col-lg-6 formulario-label-fiel">
                    <label class="formulario-label">Precio en $ Uruguayos </label>
                    <div class="formulario-label-aclaracion">
                    Es el precio sin impuestos en pesos. Para el caso de Uruguay.
                  </div>
                    <input type="text" class="formulario-field" v-model="plan.valor" placeholder="Precio" />
                  </div>

                  <div class="col-6 formulario-label-fiel">
                    <label class="formulario-label">¿Moneda en Uruguay?</label>
                    <div class="formulario-label-aclaracion">
                       Es la moneda que se usa para cobrar en Uruguay. Puede ser pesos o dolares.
                    </div>
                    <select v-model="plan.moneda" class="formulario-field">
                        <option>$</option>
                        <option>U$S</option>
                    </select>
                  </div>



                  <div class="col-lg-6 formulario-label-fiel">
                    <label class="formulario-label">Precio fuera de uruguay  </label>
                    <div class="formulario-label-aclaracion">
                    Este valor será en DOLARES.
                  </div>
                    <input type="text" class="formulario-field" v-model="plan.valor_fuera_de_uruguay" placeholder="Precio fuera de Uruguay" />
                  </div>





                  <div class="col-6 formulario-label-fiel">
                    <label class="formulario-label">¿Activo?</label>
                    <select v-model="plan.estado" class="formulario-field">
                        <option>si</option>
                        <option>no</option>
                    </select>
                  </div>





                </div>
                <div class="row mx-0 contenedor-grupo-datos">
                <div class="col-6 formulario-label-fiel">
                    <label class="formulario-label">¿Incluye control de acceso? </label>
                    <select v-model="plan.control_acceso" class="formulario-field">
                        <option>si</option>
                        <option>no</option>
                    </select>
                  </div>
                </div>

                <div class="row mx-0 contenedor-grupo-datos">
                <div class="col-6 formulario-label-fiel">
                    <label class="formulario-label">¿Incluye reserva de clases? </label>
                    <select v-model="plan.reserva_de_clases_on_line" class="formulario-field">
                        <option>si</option>
                        <option>no</option>
                    </select>
                  </div>
                </div>


                <div class="row mx-0 contenedor-grupo-datos">
                <div class="col-6 formulario-label-fiel">
                    <label class="formulario-label">¿Acepta función de grupos? </label>
                    <select v-model="plan.grupos" class="formulario-field">
                        <option>si</option>
                        <option>no</option>
                    </select>
                  </div>
                </div>






                  <div @click="editarPlan" class="mt-4 Boton-Fuente-Chica Boton-Primario-Sin-Relleno">
                    Confirmar
                  </div>





              </div>

              <div class="modal-footer">

                <button class="modal-default-button" @click="showModal = false">
                  Cancelar
                </button>

              </div>
            </div>
          </div>
        </div>
      </transition>
    </div>
  </div>`
};
