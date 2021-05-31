var reservaAdmin = {

    props:['destacaSocio','reserva'],

    data: function() {
    return {
      borrando: false,
      marcando: false,


    };
  },


    methods:{

        eliminar:function(){

        },
        marcarComoHecha:function(){

        }
    },



    template:`
                        <div class="background-hover-gris-0 mb-2 borde-bottom-gris p-2">
                          <socio-list
                            :socio="reserva.socio"
                            :empresa="$root.empresa"
                            :destacaSocio="false"
                            >
                          </socio-list>

                          <small v-if="reserva.cumplio_con_la_reserva != 'si'" class="w-100 d-flex flex-row align-items-center justify-content-between">


                            <div v-if="!marcando" @click="marcarComoHecha" class="btn cursor-pointer   btn-outline-success btn-sm">
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
                          <p v-else class="text-success">
                              Reservó y cumplió  <i class="fas fa-check-circle"></i>
                          </p>

                        </div>


    `
};
