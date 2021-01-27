Vue.component("crear-pais", {
  data: function() {
    return {
      cargando: false,
      datos_a_enviar: {
        name: "",
        code: "",
        currencyCode: "",
        estado: "si",
        imagen: ""
      },
      showModal: false
    };
  },
  methods: {
    limpiar_data_crear: function() {
      this.datos_a_enviar = {
        name: "",
        code: "",
        currencyCode: "",
        estado: "si",
        imagen: ""
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
    crear: function() {
      var url = "/crear_pais";

      var data = this.datos_a_enviar;

      var vue = this;

      axios
        .post(url, data)
        .then(function(response) {
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
   Crear un país<i class="fas fa-plus"></i>
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

            <div class="row row mx-0 contenedor-grupo-datos">
              <div class="col-lg-6 formulario-label-fiel">
               <label class="formulario-label">Nombre</label>
               <input v-model="datos_a_enviar.name" type="text" min="1" class="formulario-field" placeholder="Nombre">
              </div>

              <div class="col-lg-6 formulario-label-fiel">
               <label class="formulario-label">Código</label>
               <input v-model="datos_a_enviar.code" type="text"  class="formulario-field" placeholder="Código de país">
              </div>

              <div class="col-lg-6 formulario-label-fiel">
               <label class="formulario-label">Código de moneda</label>
               <input v-model="datos_a_enviar.currencyCode" type="text"  class="formulario-field" placeholder="Código de moneda">
              </div>


                <div class="col-12 formulario-label-fiel">
                    <label class="formulario-label">Imagen</label>
                    <input class="formulario-field" type="file" name="image" v-on:change="onImageChange" accept="image/*">
                  </div>


              <div class="col-12 formulario-label-fiel">
                <label class="formulario-label">¿Activo?</label>
                <select v-model="datos_a_enviar.estado" class="formulario-field">
                  <option>si</option>
                  <option>no</option>
                </select>

              </div>





              <div @click="crear" class="mt-4 Boton-Fuente-Chica Boton-Primario-Sin-Relleno">
                 Confirmar
              </div>
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
