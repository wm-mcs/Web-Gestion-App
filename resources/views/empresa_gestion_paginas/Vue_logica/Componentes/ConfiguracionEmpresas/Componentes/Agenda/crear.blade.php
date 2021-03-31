Vue.component("crear-agenda", {
  mixins: [onKeyPressEscapeCerrarModalMixIn,actividadeslMixIn],
  data: function () {
    return {
      cargando: false,
      diasQueRepiteArray: [],
      datos_a_enviar: {
        name: "",

        days: "",
        hora_inicio: "10:00",
        hora_fin:"11:00",
        actividad_id:'',
        tiene_limite_de_cupos:'no',
        cantidad_de_cupos:'',
        estado: "si",
        empresa_id: this.$root.empresa.id,
        sucursal_id:this.$root.Sucursal.id

      },
      showModal: false,
    };
  },
  methods: {
    limpiar_data_crear: function () {
      this.datos_a_enviar = {
        name: "",

      };
    },
    onChangeActividad:function(){

      let actividad = this.actividades.filter(
        actividad => actividad.id == this.datos_a_enviar.actividad_id
      )[0];

      this.datos_a_enviar.name = actividad.name;

    },
    handlerClose:function(){
      this.showModal = false;

    },
    crear: function () {
      var url = "/crear_agenda";

      this.datos_a_enviar.days = this.diasQueRepiteArray;

      var data = this.datos_a_enviar;
      var vue = this;

      vue.cargando = true;
      axios
        .post(url, data)
        .then(function (response) {
          var data = response.data;

          if (data.Validacion == true) {
            vue.cargando = false;
            bus.$emit("se-creo-o-edito", "hola");
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
   Crar cronograma de una actividad <i class="fas fa-plus"></i>
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

            <div class="modal-mensaje-aclarador">
                ¿Qué actividad vas a agregar al cronograma?
                </div>
              <fieldset class="float-label">

              <select required name="actividad_id" v-model="datos_a_enviar.actividad_id"  @change="onChangeActividad" class="input-text-class-primary">

                  <option :value="actividad.id" v-for="actividad in actividades" :key="actividad.id">@{{actividad.name}}</option>


                </select>

                <label for="actividad_id">Actividad</label>
              </fieldset>
            </div>





                  <div v-if="datos_a_enviar.actividad_id != ''" class="row w-100 mx-0 ">
                  <div class="modal-mensaje-aclarador col-12 px-1 ">

                  Indicá entre qué horas es
                  </div>
                  <div class="col-6 p-0">
                  <div class=" formulario-label-fiel">
                    <fieldset class="float-label">
                      <input
                        name="hora_inicio"
                        type="time"
                        class="input-text-class-primary"
                        v-model="datos_a_enviar.hora_inicio"
                        required

                      />
                      <label for="hora_inicio">Hora inicio</label>
                    </fieldset>
                  </div>
                  </div>
                  <div class="col-6 p-0">
                  <div class=" formulario-label-fiel">
                    <fieldset class="float-label">
                      <input
                        name="hora_fin"
                        type="time"
                        class="input-text-class-primary"
                        v-model="datos_a_enviar.hora_fin"
                        required

                      />
                      <label for="hora_fin">Hora fin</label>
                    </fieldset>
                  </div>
                  </div>


                  </div>



                  <div v-if="datos_a_enviar.hora_fin != '' && datos_a_enviar.hora_inicio != ''  && datos_a_enviar.actividad_id != '' " class="formulario-label-fiel">
                  <div  class="col-12 modal-mensaje-aclarador mb-2"
                  >
                  ¿En qué días se repite @{{datos_a_enviar.name}} en el horarío de @{{datos_a_enviar.hora_inicio}} hs a @{{datos_a_enviar.hora_fin}} hs ? <b>Seleccioná el o los días.</b>
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




                  <div v-if="datos_a_enviar.hora_fin != ''
                   && datos_a_enviar.hora_inicio != ''
                   && datos_a_enviar.actividad_id != ''
                   && diasQueRepiteArray.length > 0  " class="formulario-label-fiel">

                     <div class="modal-mensaje-aclarador">
                      Indicá si tiene límite de cupos-
                    </div>
                    <fieldset class="float-label">

                    <select required name="tiene_limite_de_cupos" v-model="datos_a_enviar.tiene_limite_de_cupos" class="input-text-class-primary">

                        <option>si</option>
                        <option>no</option>

                      </select>

                      <label for="tiene_limite_de_cupos">¿Tiene límite de cupos?</label>
                    </fieldset>
                  </div>


                  <div v-if="datos_a_enviar.tiene_limite_de_cupos == 'si'" class="formulario-label-fiel">

                    <div class="modal-mensaje-aclarador">
                       ¿Cuál es la cantidad máxima de personas por clase ?
                        </div>
                      <fieldset class="float-label">

                      <input
                        name="cantidad_de_cupos"
                        type="number"
                        class="input-text-class-primary"
                        v-model="datos_a_enviar.cantidad_de_cupos"
                        required

                      />

                        <label for="cantidad_de_cupos">Cantidad máxima de personas por clase</label>
                      </fieldset>
                    </div>










              <div v-if="cargando" class="Procesando-text w-100">Procesado...</div>
              <div v-else class="w-100">
              <button v-if="datos_a_enviar.hora_fin != '' && datos_a_enviar.hora_inicio != ''  && datos_a_enviar.actividad_id != '' && diasQueRepiteArray.length > 0  "  type="button" @click="crear" class="mt-4 Boton-Fuente-Chica Boton-Primario-Sin-Relleno">
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

`,
});
