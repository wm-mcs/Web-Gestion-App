var Clase = {
  mixins: [onKeyPressEscapeCerrarModalMixIn, erroresMixIn],
  props: ["clase", "actividades", "fecha", "sucursal", "dia"],
  data: function() {
    return {
      cargando: false,
      entidad: this.clase,
      showModal: false,
      error: false,
      success: false,
      menssage: ""
    };
  },
  methods: {
    onChangeActividad: function() {
      let actividad = this.actividades.filter(
        (actividad) => actividad.id == this.entidad.actividad_id
      )[0];
      this.entidad.actividad_id = actividad.id;
      this.entidad.name = actividad.name;
    },

    reservar: function() {
      var url = "/efectuar_reserva";

      const data = {
        empresa_id: this.$root.empresa.id,
        sucursal_id:this.sucursal.id,
        agenda_id: this.clase.id,
        actividad_id: this.clase.actividad_id,
        fecha_de_cuando_sera_la_clase: this.dia
      };

      var vue = this;
      vue.cargando = true;

      axios
        .post(url, data)
        .then(function(response) {
          var data = response.data;

          if (data.Validacion == true) {
            vue.cargando = false;

            vue.success = true;
            vue.message = response.data.Validacion_mensaje;

            setInterval(function() {
              vue.showModal = false;
              vue.$emit('reservo');
            }, 6000);
          } else {
            vue.cargando = false;

            vue.error = true;
            vue.message = response.data.Validacion_mensaje;
            setInterval(function() {
              vue.showModal = false;
            }, 6000);

          }
        })
        .catch(function(error) {
          vue.cargando = false;
          $.notify("Upsssssss.. algo pasó", "error");
        });
    }
  },
  computed: {
    cuposDisponibles: function() {
      return (
        parseInt(this.entidad.cantidad_de_cupos) -
        parseInt(this.entidad.reservas_del_dia)
      );
    }
  },
  mounted: function() {},
  created() {},

  template: `
  <div   class="w-100 mb-3 background-hover-gris-0">

  <div class="px-2 py-2 agenda-lista-contenedor background-gris-0" :style="{ borderLeftColor: entidad.actividad.color, opacity:entidad.estado == 'si' ? '1':'0.5'}">
    <h3 class="agenda-lista-name mb-2 simula_link" >
      <b>@{{entidad.actividad.name}}</b>
    </h3>
    <p class="agenda-lista-dato mb-2">
      <i class="far fa-clock"></i>  <b>@{{entidad.hora_inicio}}</b> a   <b>@{{entidad.hora_fin}}</b> hs.
    </p>

    <p class="agenda-lista-dato mb-0">
      <small>
      <i class="far fa-user"></i> <span v-if="entidad.tiene_limite_de_cupos == 'si'">

       Quedan  Cupo de personas máximo <b>@{{entidad.cantidad_de_cupos }}</b>  </span>
      <span v-else> No tiene límite de cupo</span>.

      <div>
        Reservas = @{{entidad.reservas_del_dia}}
      </div>

      </small>

    </p>

    <button  v-if="!entidad.auth_socio_ya_reservo" @click="showModal = true" type="button" class="btn btn-primary mt-3">Reservar</button>
    <div v-else class="color-text-success h2 my-1">
      Rerservado <i  class="fas fa-check-circle"></i>
    </div>



  </div>
  <transition name="modal" v-if="showModal">
    <div class="modal-mask ">
      <div class="modal-wrapper">
        <div class="modal-container position-relative">
        <span class="modal-cerrar-icono sub-titulos-class text-center color-text-gris" @click="showModal = !showModal">
          <i class="fas fa-times"></i>
        </span>





          <div class="modal-body">

            <div class="row  mx-0 ">

            <span  v-if="!success && !error" class="w-100">

            <div class="col-12 text-center mb-4">
            <strong>Lo que estás por reservar es:</strong>
             </div>

            <ul class="col-12 mb-4 p-3 pl-5 border rounded background-gris-1" >
                <li> Clase: <b>@{{entidad.name}} </b>  </li>
                <li> Día:  <b>@{{fecha}} </b>  </li>
                <li> Horario:     <i class="far fa-clock"></i>  De <b>@{{entidad.hora_inicio}}</b> a   <b>@{{entidad.hora_fin}}</b> hs.  </li>

                <li> En:  <b>@{{sucursal.direccion}} </b> </li>


            </ul>

            </span>




















      <transition name="fade-enter" v-if="success || error">
        <div  @click="handlerClickErrores" class="col-12 my-2 py-4  cursor-pointer w-100 border-radius-estandar borde-bottom-gris background-gris-1"  >

          <div :class="[success ? 'color-text-success' : 'color-text-error', 'h1 text-center mb-4']">
              <i v-if="success" class="fas fa-check-circle"></i>
              <i v-if="error" class="fas fa-exclamation-triangle"></i>
          </div>
          <div :class="[success ? 'color-text-success' : 'color-text-error', 'text-center mb-1']"> @{{message}}</div>
        </div>
      </transition>

        <div v-if="cargando != true"  class="d-flex flex-column align-items-center w-100">
        <button  v-if="!success && !error"  type="button" @click="reservar" class="mt-4 btn btn-lg btn-primary">
                 Reservar
              </button>
        </div>

              <div v-else class="my-3  Procesando-text w-100">
        <div class="cssload-container">
            <div class="cssload-tube-tunnel"></div>
        </div>
    </div>

            </div>



          </div>

          <div class="modal-footer">

              <div class="w-100 text-right" @click="showModal = false" >
                Cancelar
</div>

          </div>
        </div>
      </div>
    </div>
  </transition>
</span>




  </div>

`
};
