var reservaAdmin = {
  props: ["destacaSocio", "reserva"],

  data: function() {
    return {
      borrando: false,
      marcando: false
    };
  },

  methods: {
    eliminar: function() {
      var validation = confirm("¿Querés eliminar la reserva?");

      if (!validation) {
        return "";
      }
      var url = "/eliminar_reserva_desde_panel_admin";

      var data = {
        empresa_id: this.$root.empresa.id,
        sucursal_id: this.$root.Sucursal.id,
        reserva_id: this.reserva.id
      };

      var vue = this;

      vue.borrando = true;

      axios
        .post(url, data)
        .then(function(response) {
          var data = response.data;

          if (data.Validacion == true) {
            vue.borrando = false;
            vue.$emit("actualizar");
            $.notify(response.data.Validacion_mensaje, "info");
          } else {
            vue.borrando = false;

            $.notify(response.data.Validacion_mensaje, "error");
          }
        })
        .catch(function(error) {
          vue.borrando = false;
          $.notify("Upsssssss.. algo pasó", "error");
        });
    },
    marcarComoHecha: function(si_no) {
      var url = "/marcar_que_realizo_reserva_desde_panel_admin";

      var data = {
        empresa_id: this.$root.empresa.id,
        sucursal_id: this.$root.Sucursal.id,
        reserva_id: this.reserva.id,
        confirma_anula: si_no
      };

      var vue = this;

      vue.marcando = true;

      axios
        .post(url, data)
        .then(function(response) {
          var data = response.data;

          if (data.Validacion == true) {
            vue.marcando = false;
            vue.$emit("actualizar");
            $.notify(response.data.Validacion_mensaje, "success");
          } else {
            vue.marcando = false;

            $.notify(response.data.Validacion_mensaje, "error");
          }
        })
        .catch(function(error) {
          vue.marcando = false;
          $.notify("Upsssssss.. algo pasó", "error");
        });
    }
  },

  template: `
                        <div class="background-hover-gris-0 mb-2 borde-gris p-2">
                          <socio-list
                            :socio="reserva.socio"
                            :empresa="$root.empresa"
                            :destacaSocio="false"
                            >
                          </socio-list>

                          <small v-if="reserva.cumplio_con_la_reserva != 'si'" class="w-100 d-flex flex-row align-items-center justify-content-between">


                            <div v-if="!marcando" @click="marcarComoHecha('si')" class="btn cursor-pointer   btn-outline-success btn-sm">
                                Marcar que cumplió con la reserva.
                            </div>
                            <div v-else class="color-text-gris">
                                Procesando ...
                            </div>

                            <div v-if="!borrando" @click="eliminar" class="cursor-pointer color-text-gris">
                             Eliminar <i class="fas fa-trash-alt"></i>
                            </div>
                            <div v-else>
                                Borrando ...
                            </div>

                          </small>
                          <small v-else >

                            <div  v-if="marcando == false"  @click="marcarComoHecha('no')" class="text-success cursor-pointer" >
                                Reservó y cumplió  <i class="fas fa-check-circle"></i>
                            </div>
                            <div v-else class="color-text-gris" >
                                    Procesando ...
                            </div>

</small>

</div>


    `
};
