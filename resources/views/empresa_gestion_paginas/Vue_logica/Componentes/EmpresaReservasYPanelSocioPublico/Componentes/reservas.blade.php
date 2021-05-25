var Reservas = {
  mixins: [onKeyPressEscapeCerrarModalMixIn,erroresMixIn],

  props:['empresa','sucursales'],

  data: function () {
    return {
      cargando: false,
      showModal: false,

      actividades_disponibles:[],
      reservas_de_la_sucursal:[],
      sucursale_elegida_id:'',



    };
  },
  methods: {

  },
  computed: {},
  mounted: function () {

    if(this.sucursales.length > 1)
    {

    }else{
      this.sucursale_elegida_id = this.sucursales[0].id;
    }


  },
  created() {},

  template: `
  <div class="w-100 ">

  <div v-id="sucursales.length > 1"  class="formulario-label-fiel mb-4">

      <div class="h4 mb-2">
          ¿Para cuál sucursal de @{{empresa.name}} vas a reservar?
      </div>

      <fieldset class="float-label">

      <select required name="sucursal" v-model="sucursale_elegida_id"  class="input-text-class-primary">

          <option :value="sucursal.id" v-for="sucursal in sucursales" :key="sucursal.id">@{{sucursal.name}} | @{{sucursal.direccion}}</option>


        </select>

        <label for="sucursal">Elegir sucursal</label>
      </fieldset>
    </div>




  </div>

`,
};
