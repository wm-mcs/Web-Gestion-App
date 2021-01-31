Vue.component("agregar-servicio-a-empresa", {
	data: function() {
		return {
			servicio_data: {
				name: "",
				tipo: "",
				moneda: "",
				valor: "",
				fecha_vencimiento: "",
				empresa_id: this.empresa.id,
				paga: "no",
				tipo_servicio_id: ""
			},
			tipo_servicio: "",
			planes: ""
		};
	},

	props: ["empresa"],
	mounted: function mounted() {
		this.setFecha();
	},
	methods: {
		setFecha: function() {
			var fecha = new Date();
			fecha.setMonth(fecha.getMonth() + 1);

			this.servicio_data.fecha_vencimiento = fecha.toISOString().slice(0, 10);
		},
		getPlanes: function() {
			var url = "/get_planes_empresa";

			var vue = this;

			axios
				.get(url)
				.then(function(response) {
					var data = response.data;

					if (data.Validacion == true) {
						vue.planes = data.Data;
						$.notify(response.data.Validacion_mensaje, "success");
					} else {
						$.notify(response.data.Validacion_mensaje, "error");
					}
				})
				.catch(function(error) {});
		},

		abrir_modal: function() {
			this.getPlanes();

			$("#modal-agregar-servicio-socio")
				.appendTo("body")
				.modal("show");
		},
		crear_servicio_a_socio: function() {
			var url = "/agregar_servicio_a_empresa";

			var data = this.servicio_data;

			var vue = this;

			app.cargando = true;

			axios
				.post(url, data)
				.then(function(response) {
					var data = response.data;

					if (data.Validacion == true) {
						app.cargando = false;
						app.empresa = data.empresa;

						app.cerrarModal("#modal-agregar-servicio-socio");

						$.notify(data.Validacion_mensaje, "success");
					} else {
						app.cargando = false;
						$.notify(response.data.Validacion_mensaje, "warn");
					}
				})
				.catch(function(error) {});
		},
		cambioTipoDeServicio: function() {
			var servicio = this.seleccionarUnObjetoSegunAtributo(
				this.planes,
				"name",
				this.tipo_servicio
			);

			this.servicio_data.name = servicio.name;
			this.servicio_data.tipo = servicio.tipo;
			this.servicio_data.moneda = servicio.moneda;
			this.servicio_data.valor = servicio.valor;
			this.servicio_data.tipo_servicio_id = servicio.id;
		},
		seleccionarUnObjetoSegunAtributo: function(lista, atributo, valor) {
			return lista.find(function(element) {
				return element.name == valor;
			});
		}
	},
	template: `<span>
 <div id="boton-editar-socio" style="position:relative;" class="admin-user-boton-Crear panel-socio-agrega-margin-left-boton" v-on:click="abrir_modal">
        <i class="fas fa-cash-register"></i> Vender plan
       
 </div>

    <div class="modal fade" id="modal-agregar-servicio-socio" tabindex="+1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel"> Agregar un plan a @{{empresa.name}}</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fas fa-times"></i></span></button>
          
        </div>
        <div class="modal-body text-center"> 

                

              

                 <div v-if="planes.length" class="formulario-label-fiel">
                      <label class="formulario-label" >Tipo de servicio <span class="formulario-label-aclaracion"> ¿por clase o mensual?</span></label>
                     <select v-on:change="cambioTipoDeServicio" class="form-control" v-model="tipo_servicio">
                        <option></option>
                        <option v-for="servicio in planes">@{{servicio.name}}</option>
                       
                        
                      </select>
                  </div> 

                  <div  class="formulario-label-fiel" v-if="servicio_data.name">
                      <label class="formulario-label" >Nombre <span class="formulario-label-aclaracion"> Puedes cambiar este nombre si quieres</span></label>
                      <input type="text" class="formulario-field"  v-model="servicio_data.name" placeholder="Nombre"   />
                  </div> 

                  

                    <div  class="formulario-label-fiel" v-if="servicio_data.moneda">
                      <label class="formulario-label" >Moneda</label>
                      <select v-model="servicio_data.moneda" class="form-control">
                        <option>$</option>
                        <option>U$S</option>
                        
                       
                        
                      </select>
                    </div> 

                    

                     <div  class="formulario-label-fiel" v-if="servicio_data.valor">
                      <label class="formulario-label" >Valor <span v-if="servicio_data.cantidad_de_servicios"> de todas las clases</span> </label>
                      <input type="text" class="formulario-field"  v-model="servicio_data.valor"   />
                     </div> 


                     <div  class="formulario-label-fiel" v-if="servicio_data.name">
                      <label class="formulario-label" >Fecha de vencimiento <span class="formulario-label-aclaracion"> por defecto es a un més</span></label>
                      <input type="date" class="formulario-field"  v-model="servicio_data.fecha_vencimiento"    />
                     </div> 

                      <div  class="formulario-label-fiel" v-if="servicio_data.name">
                      <label class="formulario-label" >¿Lo paga ahora? <span class="formulario-label-aclaracion"> puede que quede debiendo</span></label>
                      <div class="form-control">
                        <input type="radio" id="si" value="si" v-model="servicio_data.paga">
                        <label for="si">si</label>

                         <input type="radio" id="no" value="no" v-model="servicio_data.paga">
                         <label for="no">no</label>
                      </div>
                      
                     </div> 



                     



               

                  <div v-on:click="crear_servicio_a_socio" class="boton-simple">Agregar</div>
                  
                 
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>        
        </div>
      </div>
    </div>
  </div>
  
   
  

</span>`
});
