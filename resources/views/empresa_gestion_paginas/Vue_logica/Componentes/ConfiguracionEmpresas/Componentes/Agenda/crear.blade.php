Vue.component("crear-agenda", {
  mixins: [onKeyPressEscapeCerrarModalMixIn],
  data: function () {
    return {
      cargando: false,
      diasQueRepiteArray: [0, 1, 2, 3],
      datos_a_enviar: {
        name: "",

        currencyCode: "",
        estado: "si",
        imagen: "",
      },
      showModal: false,
    };
  },
  methods: {
    limpiar_data_crear: function () {
      this.datos_a_enviar = {
        name: "",
        code: "",
        currencyCode: "",
        estado: "si",
        imagen: "",
      };
    },
    onImageChange(e) {
      let files = e.target.files || e.dataTransfer.files;
      if (!files.length) return;
      this.createImage(files[0]);
    },
    createImage(file) {
      let reader = new FileReader();
      let vm = this;
      reader.onload = (e) => {
        vm.datos_a_enviar.imagen = e.target.result;
      };
      reader.readAsDataURL(file);
    },
    crear: function () {
      var url = "/crear";

      var data = this.datos_a_enviar;

      var vue = this;

      axios
        .post(url, data)
        .then(function (response) {
          var data = response.data;

          if (data.Validacion == true) {
            vue.cargando = false;
            bus.$emit("se-creo-o-edito-pais", "hola");
            vue.showModal = false;
            vue.limpiar_data_crear();
            $.notify(response.data.Validacion_mensaje, "success");
          } else {
            vue.cargando = false;
            $.notify(response.data.Validacion_mensaje, "error");
          }
        })
        .catch(function (error) {
          vue.cargando = false;
          $.notify("Upsssssss.. algo pasó", "error");
        });
    },
  },
  computed: {},
  mounted: function () {},

  template: `<span>


  <button type="button" class="Boton-Fuente-Chica Boton-Primario-Relleno " @click="showModal = true">
   Crear actividad <i class="fas fa-plus"></i>
  </button>


  <transition name="modal" v-if="showModal">
    <div class="modal-mask ">
      <div class="modal-wrapper">
        <div class="modal-container position-relative">
        <span class="modal-cerrar-icono sub-titulos-class text-center color-text-gris" @click="showModal = !showModal">
          <i class="fas fa-times"></i>
        </span>


          <div class="row">
            <h4 class="col-12 sub-titulos-class" > Crear</h4>
            <div class="col-12 modal-mensaje-aclarador">

            </div>
          </div>

          <div class="modal-body">

            <div class="row  mx-0 ">


                <div class="formulario-label-fiel">
                    <fieldset class="float-label">
                      <input
                        name="name"
                        type="text"
                        class="input-text-class-primary"
                        v-model="datos_a_enviar.name"
                        required

                      />
                      <label for="name">Nombre</label>
                    </fieldset>
                  </div>

                  <div class="formulario-label-fiel">
                  <div  class="col-12 formulario-label"
                  >
                  Los días que se repite son ...
                  </div>
                  <div class="col-12">
                      <label for="lunes">Lunes</label>
                      <input type="checkbox" id="lunes" value="0" v-model="diasQueRepiteArray">
                  </div>
                  <div class="col-12">
                      <label for="martes">Martes</label>
                      <input type="checkbox" id="martes" value="1" v-model="diasQueRepiteArray">
                  </div>
                  <div class="col-12">
                      <label for="miercoles">Miércoles</label>
                      <input type="checkbox" id="miercoles" value="2" v-model="diasQueRepiteArray">
                  </div>
                  <div class="col-12">
                      <label for="jueves">Jueves</label>
                      <input type="checkbox" id="jueves" value="3" v-model="diasQueRepiteArray">
                  </div>
                  <div class="col-12">
                      <label for="viernes">Viernes</label>
                      <input type="checkbox" id="viernes" value="4" v-model="diasQueRepiteArray">
                  </div>
                  <div class="col-12">
                      <label for="sabado">Sábado</label>
                      <input type="checkbox" id="sabado" value="5" v-model="diasQueRepiteArray">
                  </div>
                  <div class="col-12">
                      <label for="domingo">Domingo</label>
                      <input type="checkbox" id="domingo" value="6" v-model="diasQueRepiteArray">
                  </div>



                  </div>











              <div class="col-12 formulario-label-fiel">
                <label class="formulario-label">¿Activo?</label>
                <select v-model="datos_a_enviar.estado" class="formulario-field">
                  <option>si</option>
                  <option>no</option>
                </select>

              </div>





              <button type="button" @click="crear" class="mt-4 Boton-Fuente-Chica Boton-Primario-Sin-Relleno">
                 Confirmar
              </button>
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

`,
});
