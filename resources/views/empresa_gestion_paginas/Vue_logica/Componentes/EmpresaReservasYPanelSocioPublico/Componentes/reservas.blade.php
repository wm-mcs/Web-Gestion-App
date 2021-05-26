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
      clases_para_reservar:[]



    };
  },
  methods: {


    getClasesParaReservar:function(){

      var url = "/get_clases_para_reservar_public";

      var data = {sucursal_id:this.sucursale_elegida_id};

      var vue = this;

      vue.cargando = true;
      vue.errores = [];

      axios
        .post(url, data)
        .then(function(response) {
          var data = response.data;

          if (data.Validacion == true) {
            vue.cargando = false;
            vue.clases_para_reservar = data.Data;
          } else {
            vue.cargando = false;
            vue.setErrores(data.Data);
            $.notify(response.data.Validacion_mensaje, "error");
          }
        })
        .catch(function(error) {
          vue.cargando = false;
          $.notify("Upsssssss.. algo pasó", "error");
        });

    }

  },
  computed: {},
  mounted: function () {

    if(this.sucursales.length > 1)
    {

    }else{
      this.sucursale_elegida_id = this.sucursales[0].id;
      this.getClasesParaReservar();
    }


  },
  created() {},

  template: `
  <div class="w-100 ">

    <div class="h2 mb-4">
      Reservar clase
    </div>

  <div v-id="sucursales.length > 1"  class="formulario-label-fiel mb-4">



      <div class="h5 mb-2">
          ¿Para cuál sucursal de @{{empresa.name}} vas a reservar?
      </div>

      <fieldset class="float-label">
        <select @change="getClasesParaReservar()" required name="sucursal" v-model="sucursale_elegida_id"  class="input-text-class-primary">
            <option :value="sucursal.id" v-for="sucursal in sucursales" :key="sucursal.id">@{{sucursal.name}} | @{{sucursal.direccion}}</option>
        </select>

        <label for="sucursal">Elegir sucursal</label>
      </fieldset>
    </div>




  </div>

`,
};
