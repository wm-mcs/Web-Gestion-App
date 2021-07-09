Vue.component("reservas-admin", {
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
      agendas:[],
      urlReservas:"{{$Empresa->route_reservas}}"

    };
  },
  methods: {
    copiarAlPortaPapelesLinkDeReserva: function(){
      let url = this.urlReservas ;


  var aux = document.createElement("input");


  aux.setAttribute("value", url);


  document.body.appendChild(aux);


  aux.select();


  let validation = document.execCommand("copy");


  document.body.removeChild(aux);

  if(validation){
    $.notify('Se copió al portapapeles', "success");
  }

      console.log(url);
    },
    abrirModal:function(){
        this.showModal = true;
        if(this.reservas.length == 0)
        {
            this.dia = new Date().toISOString().slice(0, 10);
            this.getReservas(true);
        }
    },
    getReservas: function(cargando) {
      var url = "/get_reservas_del_dia";

      var data = {empresa_id:this.$root.empresa.id,
                  sucursal_id:this.$root.Sucursal.id,
                  fecha:this.dia  };

      var vue = this;

      vue.cargando =  cargando ? true :false;


      axios
        .post(url, data)
        .then(function(response) {
          var data = response.data;

          if (data.Validacion == true) {
            vue.cargando = false;
            vue.agendas  = data.Data.agendas;
            vue.reservas = data.Data.reservas;

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
     <i class="far fa-calendar-alt"></i>  Reservas del día
  </div>





  <transition name="modal" v-if="showModal">
  <div class="modal-mask ">
    <div class="modal-wrapper">
      <div class="modal-container position-relative">
      <span class="modal-cerrar-icono sub-titulos-class text-center color-text-gris" @click="showModal = !showModal">
        <i class="fas fa-times"></i>
      </span>


        <div class="row">

        <div class="text-center col-12 mb-5">
          <a href="whatsapp://send?text={{$Empresa->route_reservas}}" data-text="Reservas de clases online" data-action="share/whatsapp/share" class="">
            <small> Compartir por <i class="fab fa-whatsapp"></i> link de reservas <i class="fas fa-share"></i></small>
          </a>

          <div @click="copiarAlPortaPapelesLinkDeReserva" class="simula_link">
            <small> Copiar link de reservas</small>
          </div>

        </div>
          <h4 class="col-12 sub-titulos-class text-center" > Reservas del día  @{{dia}}</h4>
          <div class="col-12 modal-mensaje-aclarador text-center">
                Puedes cambiar la fecha para ver las reservas de otro día.
          </div>



        </div>


        <div class="modal-body">

         <div  class="row mx-0">
          <div class="col-12">
                    <div class="formulario-label-fiel">
                        <fieldset class="float-label">
                        <input
                            @change="getReservas(true)"
                            name="dia"
                            type="date"
                            class="input-text-class-primary"
                            v-model="dia"
                            required

                        />
                        <label for="dia">Reservas del día:</label>
                        </fieldset>
                    </div>
          </div>

         </div>

        <div v-if="!cargando" class="w-100">

            <div class="mb-1 w-100" v-if="reservas.length > 0 && agendas.length > 0 " >


               <div class="mb-4 " v-for="agenda in agendas" :key="agenda.id + 'agenda'">
                <div>
                    <b>@{{agenda.actividad.name}}  </b> hora inicio: @{{agenda.hora_inicio}} hs
                </div>


                <div v-if="filterReservas(agenda.id).length > 0"  class="ml-2  w-100">
                    <div class="w-100" v-for="reserva in filterReservas(agenda.id)" >

                          <reserva-admin-lista @actualizar="getReservas(false)" :destaca-socio="true" :reserva="reserva" :key="reserva.id">


                          </reserva-admin-lista>

                    </div>

                </div>
                <div v-else class="color-text-gris col-12 my-2 text-center">
                        <small>No hay reservas para la clase de <b>@{{agenda.actividad.name}}  </b> hora inicio: @{{agenda.hora_inicio}}</small>
                    </div>


               </div>




            </div>
            <div v-else class="color-text-gris col-12 my-4 text-center">
                No hay reservas para el día @{{dia}}
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
