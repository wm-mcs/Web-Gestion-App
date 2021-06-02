Vue.component("reservas-historicas", {
  mixins: [onKeyPressEscapeCerrarModalMixIn],

  components:{
      'reserva-admin-lista':reservaAdmin
  },


  data: function() {
    return {
      cargando: false,
      showModal: false,
      sucursal: this.$root.Sucursal,
      dia:'',
      reservas:[],

      socio_id:{!! json_encode($Socio_id) !!},

    };
  },
  methods: {
    abrirModal:function(){
        this.showModal = true;
        if(this.reservas.length == 0)
        {
            this.dia = new Date().toISOString().slice(0, 10);
            this.getReservas(true);
        }
    },
    getReservas: function(cargando) {
      var url = "/get_reservas_historicas_del_socio";

      var data = {empresa_id:this.$root.empresa.id,
                  sucursal_id:this.$root.Sucursal.id,
                  socio_id:this.socio_id  };

      var vue = this;

      vue.cargando =  cargando ? true :false;


      axios
        .post(url, data)
        .then(function(response) {
          var data = response.data;

          if (data.Validacion == true) {
            vue.cargando = false;
            vue.reservas = data.Data;

          } else {
            vue.cargando = false;

            $.notify(response.data.Validacion_mensaje, "error");
          }
        })
        .catch(function(error) {
          vue.cargando = false;
          $.notify("Upsssssss.. algo pasó", "error");
        });
    },
    filterReservas:function(agenda_id){
        return this.reservas.filter(
            reserva => reserva.agenda_id == agenda_id
        );
    },

  },
  computed: {},
  mounted: function() {

  },
  created() {},

  template: `

<div class="col-12">

  <div  @click="abrirModal" class="Boton-Primario-Sin-Relleno">
     Reservas de clases históricas
  </div>





  <transition name="modal" v-if="showModal">
  <div class="modal-mask ">
    <div class="modal-wrapper">
      <div class="modal-container position-relative">
      <span class="modal-cerrar-icono sub-titulos-class text-center color-text-gris" @click="showModal = !showModal">
        <i class="fas fa-times"></i>
      </span>


        <div class="row">
          <h4 class="col-12 sub-titulos-class text-center" > Reservas históricas </h4>
          <div class="col-12 modal-mensaje-aclarador text-center">
                Son todas las reservas de clases que ha hecho el socio.
          </div>



        </div>


        <div class="modal-body">



        <div v-if="!cargando" class="w-100">

            <div class="mb-1 w-100" v-if="reservas.length > 0 " >





                <div v-if="reservas.length > 0"  class="ml-2  w-100">
                    <div class="w-100" v-for="reserva in reservas" >

                          <reserva-admin-lista @actualizar="getReservas(false)" :reserva="reserva" :key="reserva.id">


                          </reserva-admin-lista>

                    </div>

                </div>
                <div v-else class="color-text-gris col-12 my-2 text-center">
                        <small>No ha hecho ninguna reserva</small>
                    </div>







            </div>
            <div v-else class="text-center">
                No ha hecho ninguna reserva de clase
            </div>


         </div>
        <div v-else class="my-5  Procesando-text w-100">
            <div class="cssload-container">
                <div class="cssload-tube-tunnel"></div>
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

</div>

















`
});
