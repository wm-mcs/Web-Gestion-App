var ListaGrupo = {
  mixins: [onKeyPressEscapeCerrarModalMixIn,erroresMixIn],
  props: ["entidad"],
  data: function () {
    return {
      cargando: false,
      entidadAEditar: this.entidad,
      showModal: false,

    };
  },
  methods: {
    edit: function () {
      var url = "/editar_grupo";

      var data = {
        empresa_id: this.$root.empresa.id,
        sucursal_id: this.$root.Sucursal.id,
        id: this.entidadAEditar.id,
        name: this.entidadAEditar.name,
        estado: this.entidadAEditar.estado,
        color: this.entidadAEditar.color,
        description:this.entidadAEditar.description
      };

      var vue = this;
      vue.cargando = true;
      vue.errores = [];

      axios
        .post(url, data)
        .then(function (response) {
          var data = response.data;

          if (data.Validacion == true) {
            vue.cargando = false;

            vue.showModal = false;
            $.notify(response.data.Validacion_mensaje, "success");
          } else {
            vue.cargando = false;
            vue.setErrores(data.Data);
            $.notify(response.data.Validacion_mensaje, "error");
          }
        })
        .catch(function (error) {
          vue.cargando = false;
          $.notify("Upsssssss.. algo pasó", "error");
        });
    },
    delet:function(){

      var url = "/eliminarGrupo";
      var data = {
        empresa_id: this.$root.empresa.id,
        sucursal_id: this.$root.Sucursal.id,
        grupo_id: this.entidadAEditar.id,

      };

      var vue = this;
      vue.cargando = true;
      vue.errores = [];

      axios
        .post(url, data)
        .then(function (response) {
          var data = response.data;

          if (data.Validacion == true) {
            vue.cargando = false;
            vue.showModal = false;
            bus.$emit("se-creo-o-edito", "hola");
            $.notify(response.data.Validacion_mensaje, "success");
          } else {
            vue.cargando = false;
            vue.setErrores(data.Data);
            $.notify(response.data.Validacion_mensaje, "error");
          }
        })
        .catch(function (error) {
          vue.cargando = false;
          $.notify("Upsssssss.. algo pasó", "error");
        });
    }
  },
  computed: {},
  mounted: function () {

  },
  created() {},

  template: `
  <div class="col-12 col-lg-4">

  <div class="px-2 py-2 agenda-lista-contenedor background-gris-0 mb-3" :style="{ borderLeftColor: entidadAEditar.color, opacity:entidadAEditar.estado == 'si' ? '1':'0.5'}">
    <h3 class="mb-3 h5 simula_link" @click="showModal = true" >
      @{{entidadAEditar.name}} <i class="fas fa-edit"></i>
    </h3>
    <p class="">
      @{{entidadAEditar.description}}
    </p>

    <p v-if="entidadAEditar.estado != 'si'" class="mt-2 mb-0 text-uppercase">
      DESACTIVADA
    </p>


  </div>


  <transition name="modal" v-if="showModal">
    <div class="modal-mask ">
      <div class="modal-wrapper">
        <div class="modal-container position-relative">
        <span class="modal-cerrar-icono sub-titulos-class text-center color-text-gris" @click="showModal = !showModal">
          <i class="fas fa-times"></i>
        </span>


          <div class="row">
            <h4 class="col-12 sub-titulos-class" > Editar @{{entidadAEditar.name}}</h4>
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
                        v-model="entidadAEditar.name"
                        required

                      />
                      <label for="name">Nombre</label>
                    </fieldset>
                  </div>

                  <div class="formulario-label-fiel">
                    <fieldset class="float-label">
                      <textarea
                        name="description"

                        class="input-text-class-primary"
                        v-model="entidadAEditar.description"
                        required

                      >
                      </textarea>
                      <label for="description">Descripción</label>
                    </fieldset>
                  </div>


                  <div class="formulario-label-fiel">
                    <fieldset class="float-label">
                      <input
                        name="color"
                        type="color"
                        class="input-text-class-primary"
                        v-model="entidadAEditar.color"
                        required

                      />
                      <label for="color">Color</label>
                    </fieldset>


                  </div>

              <div class="col-12 formulario-label-fiel">
                <label class="formulario-label">¿Activo?</label>
                <select v-model="entidadAEditar.estado" class="formulario-field">
                  <option>si</option>
                  <option>no</option>
                </select>

              </div>

              <transition name="fade-enter" v-if="errores.length > 0">
        <div class="col-12 my-2 py-2 background-error cursor-pointer"  >
          <div @click="handlerClickErrores" class="color-text-error mb-1" v-for="error in errores">@{{error[0]}}</div>
        </div>
      </transition>



              <button v-if="cargando != true" type="button" @click="edit" class="mt-4 Boton-Fuente-Chica Boton-Primario-Sin-Relleno">
                 Editar
              </button>
              <div v-else class="my-3  Procesando-text w-100">
              <div class="cssload-container">
                  <div class="cssload-tube-tunnel"></div>
              </div>
              </div>

              <div  v-if="cargando != true" @click="delet" class="col-12 text-center mt-5 helper-fuente-pequeña">
                Eliminar este grupo
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




  </div>

`,
};
