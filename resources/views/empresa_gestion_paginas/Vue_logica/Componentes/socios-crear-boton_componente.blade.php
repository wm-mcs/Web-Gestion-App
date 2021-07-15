Vue.component("socios-crear-boton", {
  props: {
    accion_name: String,
    empresa: Object
  },

  data: function() {
    return {
      form_socio_name: "",
      form_socio_email: "",
      form_socio_celular: "",
      form_socio_cedula: "",
      modal: "#modal-crear-socio",
      mostrarMasDatos: false
    };
  },

  methods: {
    abrir_modal: function() {
      $(this.modal)
        .appendTo("body")
        .modal("show");
    },
    crear_socio_post: function() {
      var url = "/post_crear_socio_desde_modal";

      var data = {
        name: this.form_socio_name,
        email: this.form_socio_email,
        celular: this.form_socio_celular,
        cedula: this.form_socio_cedula,
        empresa_id: this.empresa.id
      };
      var vue = this;
      app.cargando = true;

      axios
        .post(url, data)
        .then(function(response) {
          var data = response.data;

          if (data.Validacion == true) {
            app.cargando = false;
            bus.$emit("socios-set", response.data.Socios);
            app.cerrarModal(vue.modal);
            $.notify(response.data.Validacion_mensaje, "success");
          } else {
            app.cargando = false;
            const dataError = response.data.Validacion_mensaje;

            console.log(dataError);
            if(typeof dataError === 'object')
            {
              const valores = Object.values(dataError);
              valores.forEach((element) => {

              return $.notify(element[0], "error");
             });
            }
            else{
              $.notify(dataError, "error");
            }


          }
        })
        .catch(function(error) {
          $.notify(error.message, "error");
        });
    }
  },
  computed: {
    boton_crear_validation: function() {
      if ((this.form_socio_name != "") & (this.form_socio_celular != "")) {
        return true;
      } else {
        return false;
      }
    }
  },
  template: `<span >
   <div id="socio-boton-crear" style="position:relative;" class="admin-user-boton-Crear" v-on:click="abrir_modal">
         <i class="fas fa-user-plus" title="Crear nuevo socio"></i>






  </div>

         <div class="modal fade" id="modal-crear-socio" tabindex="+1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">@{{accion_name}} nuevo socio</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fas fa-times"></i></span></button>

        </div>
        <div class="modal-body">



                  <div class="formulario-label-fiel">
                    <fieldset class="float-label">
                      <input
                        name="name"
                        type="text"
                        class="input-text-class-primary"
                        v-model="form_socio_name"
                        required

                      />
                      <label for="name">Nombres y apellidos</label>
                    </fieldset>
                  </div>

                  <div class="formulario-label-fiel">

                    <fieldset class="float-label">
                      <input
                        name="celular"
                        type="number"
                        class="input-text-class-primary"
                        v-model="form_socio_celular"
                        required

                      />
                      <label for="celular">Celular</label>
                    </fieldset>
                  </div>

                  <div class="formulario-label-fiel mb-0">
                    <fieldset class="float-label mb-0">
                      <input
                        name="email"
                        type="text"
                        class="input-text-class-primary"
                        v-model="form_socio_email"
                        required

                      />
                      <label for="email">Email (opcional) </label>
                    </fieldset>
                  </div>
                  <div class="modal-mensaje-aclarador mb-5 mt-0 col-12 text-center">
                       Si le agregás el email, podremos enviar mensajes automáticos. Por ejemplo para avisarle cuando se le venció el servicio que haya comprado.
                   </div>





                  <p class="text-center my-3 simula-link" @click="mostrarMasDatos = !mostrarMasDatos">  @{{ mostrarMasDatos ? 'Ocultar datos opcionales':'Desplegar datos opcionales' }}

                    <i v-if="!mostrarMasDatos" class="fas fa-chevron-down"></i>
                    <i v-else class="fas fa-chevron-up"></i>

                  </p>

                  <transition name="slide-fade">
                  <div  v-if="mostrarMasDatos" class="">




                  <div class="formulario-label-fiel">
                    <fieldset class="float-label">
                      <input
                        name="cedula"
                        type="number"
                        class="input-text-class-primary"
                        v-model="form_socio_cedula"
                        required

                      />
                      <label for="cedula">Número de cédula/DNI (opcional sin puntos ni guión)</label>
                    </fieldset>
                  </div>




                  </div>

                  </transition>




                  <div v-if="$root.cargando" class="Procesando-text">Procesado...</div>
                  <div v-else v-on:click="crear_socio_post" class="mt-5 boton-simple">@{{$root.boton_aceptar_texto}}</div>


        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">@{{$root.boton_cancelar_texto}}</button>
        </div>
      </div>
    </div>
  </div>













</span>
   `
});
