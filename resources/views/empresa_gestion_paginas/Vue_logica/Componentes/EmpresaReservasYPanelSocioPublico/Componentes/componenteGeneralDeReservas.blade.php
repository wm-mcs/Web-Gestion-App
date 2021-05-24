Vue.component("componente-general-reservas", {
  mixins: [onKeyPressEscapeCerrarModalMixIn,erroresMixIn],
  components:{
    'reservas':Reservas,

  },
  props: ["empresa",'default-que-mostrar'],
  data: function () {
    return {
      cargando: false,
      showModal: false,
      queMostrar: this.defaultQueMostrar

    };
  },
  methods: {

  },
  computed: {},
  mounted: function () {
    console.log(this.defaultQueMostrar);
  },
  created() {},

  template: `
  <div class="w-100 row ">
  <div class="col-6">
    <div>
      <label :class="[queMostrar == 'reserva' ? 'Boton-Primario-Relleno' : 'Boton-Primario-Sin-Relleno', 'Boton-Fuente-Muy-Chica']">
        <input style="visibility:hidden;"  type="radio" value="reserva" v-model="queMostrar"> RESERVAR
      </label>
    </div>
  </div>
  <div class="col-6">
      <label :class="[queMostrar == 'rutinas' ? 'Boton-Primario-Relleno' : 'Boton-Primario-Sin-Relleno', 'Boton-Fuente-Muy-Chica']">
        <input style="visibility:hidden;" type="radio" value="rutinas" v-model="queMostrar"> RUTINAS
      </label>
  </div>


            <reservas  v-if="queMostrar == 'reserva'">

            </reservas>








             <div  v-if="queMostrar == 'rutinas'">
                HOLA @{{queMostrar}}
             </div>





  </div>

`,
});
