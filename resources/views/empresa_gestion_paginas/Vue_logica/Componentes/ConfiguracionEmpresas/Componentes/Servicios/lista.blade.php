var ListaActividad = {
  mixins: [onKeyPressEscapeCerrarModalMixIn],
  props: ["entidad", "actividades"],
  data: function () {
    return {
      cargando: false,
      entidadAEditar: this.entidad,
      showModal: false,
      array_cantidad_de_dias: cantidadDeDiasArray,
      actividad_habilitadas:[]

    };
  },
  methods: {
    edit: function () {
      var url = "/editar_servicio";

      var data = {
        empresa_id: this.$root.empresa.id,
        id: this.entidadAEditar.id,
        name: this.entidadAEditar.name,
        moneda: this.entidadAEditar.moneda,
        valor: this.entidadAEditar.valor,
        tipo: this.entidadAEditar.tipo,
        cantidad_clases: this.entidadAEditar.cantidad_clases,
        todo_las_clases_actividades_habilitadas: this.entidadAEditar.todo_las_clases_actividades_habilitadas,
        renovacion_cantidad_en_dias: this.entidadAEditar
          .renovacion_cantidad_en_dias,
          actividad_habilitadas:this.actividad_habilitadas
      };

      var vue = this;
      vue.cargando = true;

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
  mounted: function () {

    if(this.entidadAEditar.actividad_habilitadas != null && this.entidadAEditar.actividad_habilitadas != '')
    {
      this.actividad_habilitadas = this.entidadAEditar.actividad_habilitadas.split(',');
    }
    else{
      this.actividad_habilitadas = [];
    }

  },
  created() {},

  template: `
  <div class="col-6 col-lg-4 mb-3">

  <div class="p-3 mb-3 border-radius-estandar borde-gris background-white h-100">

  <div class="row mx-0">
    <p  @click="showModal = true" class="col-10 mb-0 text-color-black ">
      <b>@{{entidadAEditar.name}}</b>
    </p>
    <p  @click="showModal = true" class=" mb-0 col-2 sub-titulos-class text-center simula-link">
      <i class="far fa-edit"></i>
    </p>
    <p class="mb-0 mt-3 col-12" :class="entidadAEditar.estado == 'si' ? 'color-text-success' : 'color-text-gris' ">
      @{{entidadAEditar.estado == 'si' ? 'Activo' : 'Desactivado'}}
  </p>

  </div>

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
                  <select  name="tipo" required v-model="entidadAEditar.tipo" class="input-text-class-primary">
                      <option>clase</option>
                      <option>mensual</option>
                  </select>
                    <label for="tipo">¿Por clase o mensual?</label>
                  </fieldset>
                </div>





                <div v-if="entidadAEditar.tipo == 'clase'" class="formulario-label-fiel">
                  <fieldset class="float-label">
                    <input
                      name="cantidad_clases"
                      type="nimber"
                      class="input-text-class-primary"
                      v-model="entidadAEditar.cantidad_clases"
                      required
                      step="any"

                    />
                    <label for="cantidad_clases">Cantidad de clases <span class="text-muted"> ¿Cuántas clases tiene la cuponera? </span></label>
                  </fieldset>
                </div>

                <div v-if="$root.aceptaDolares" class="col-12 col-lg-4 formulario-label-fiel">
                  <label class="formulario-label">¿Pesos o Dolares?</label>
                  <select v-model="entidadAEditar.moneda" class="formulario-field">
                    <option>$</option>
                    <option>U$S</option>
                  </select>
                </div>

                <div v-if="entidadAEditar.tipo == 'mensual' || entidadAEditar.cantidad_clases > 0 " class="formulario-label-fiel">
                  <fieldset class="float-label">
                    <input
                      name="valor"
                      type="nomber"
                      class="input-text-class-primary"
                      v-model="entidadAEditar.valor"
                      required
                      step="any"

                    />
                    <label for="valor">¿Cuánto cuesta?  <span v-if="entidadAEditar.tipo == 'clase' " >   El valor total de las <b> @{{entidadAEditar.cantidad_clases}} clases </b> </span> </label>
                  </fieldset>
                </div>


                <div class="formulario-label-fiel">
                  <fieldset class="float-label">

                  <select name="renovacion_cantidad_en_dias" required v-model="entidadAEditar.renovacion_cantidad_en_dias" class="formulario-field">
                    <option v-for="cantidad_dias in array_cantidad_de_dias" :value="cantidad_dias.cantidad_de_dias_numero">
                      @{{cantidad_dias.cantidad_de_dias_texto}}
                    </option>
                  </select>
                    <label for="renovacion_cantidad_en_dias">Se vence en</label>
                  </fieldset>
                </div>


                <div v-if="$root.empresa.reserva_online_habilitado" class="w-100">
                <div class="formulario-label-fiel mb-0">
                <fieldset class="float-label">

                  <select  name="todo_las_clases_actividades_habilitadas" required v-model="entidadAEditar.todo_las_clases_actividades_habilitadas" class="formulario-field">
                  <option>si</option>
                  <option>no</option>
                  </select>
                  <label for="todo_las_clases_actividades_habilitadas">¿Acepta toda las actividades?</label>
                </fieldset>
                </div>



                  <div  v-if="entidadAEditar.todo_las_clases_actividades_habilitadas == 'no'" class="formulario-label-fiel">
                  <div  class="col-12 formulario-label"
                  >
                  ¿Cuáles son las actividades que incluye? Marcá con check las que acepta.
                  </div>
                  <div v-for="actividad in actividades" :key="actividad.id" class="col-12">
                      <label :for="actividad.name">@{{actividad.name}}</label>
                      <input type="checkbox" :id="actividad.name" :value="actividad.id" v-model="actividad_habilitadas">
                  </div>






                </div>
                </div>



                <div class="formulario-label-fiel">
                  <fieldset class="float-label">

                  <select  name="estado" required v-model="entidadAEditar.estado" class="formulario-field">
                  <option>si</option>
                  <option>no</option>
                </select>
                    <label for="estado">¿Activo?</label>
                  </fieldset>
                </div>








              <div v-if="cargando" class="Procesando-text w-100">Procesado...</div>
              <div v-else class="w-100">
              <h5 class="text-center col-12 my-4"  v-if="entidadAEditar.tipo == 'clase' && entidadAEditar.cantidad_clases < 1 ">
                  La cantidad de clases debe ser mayor a 0.
              </h5>
              <button v-else type="button" @click="edit" class="mt-4 Boton-Fuente-Chica Boton-Primario-Sin-Relleno">
                 Confirmar
              </button>
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
