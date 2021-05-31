var Reservas = {
  mixins: [onKeyPressEscapeCerrarModalMixIn,erroresMixIn],
  components:{
    'clase':Clase
  },
  props:['empresa','sucursales'],

  data: function () {
    return {
      cargando: false,
      showModal: false,

      actividades_disponibles:[],
      reservas_de_la_sucursal:[],
      sucursale_elegida:'',
      clases_para_reservar:[],
      actividades:[]



    };
  },
  methods: {


    getActividades: function () {
      var url = "/get_actividad_desde_reserva";

      var data = {  };

      var vue = this;


      axios
        .post(url, data)
        .then(function (response) {
          var data = response.data;

          if (data.Validacion == true) {

            vue.actividades = data.Data;
          } else {

            $.notify(response.data.Validacion_mensaje, "error");
          }
        })
        .catch(function (error) {

          $.notify("Upsssssss.. algo pasó", "error");
          location.reload();
        });
    },


    getClasesParaReservar:function(loader){



      var url = "/get_clases_para_reservar_public";

      var data = {sucursal_id:this.sucursale_elegida.id                 };

      var vue = this;

      console.log(loader);

      vue.cargando = loader ? true : false;
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
          location.reload();
        });

    }

  },
  computed: {},
  mounted: function () {

    this.getActividades();

    if(this.sucursales.length > 1)
    {

    }else{
      this.sucursale_elegida = this.sucursales[0];
      this.getClasesParaReservar(true);
    }


  },
  created() {},

  template: `
  <div class="w-100 ">

    <div class="h2 mb-4">
      Reservar clase
    </div>

  <div  class="formulario-label-fiel mb-4">



      <div class="h5 mb-2">
          ¿Para cuál sucursal de @{{empresa.name}} vas a reservar?
      </div>

      <fieldset class="float-label">
        <select @change="getClasesParaReservar(true)" required name="sucursal" v-model="sucursale_elegida"  class="input-text-class-primary">
            <option :value="sucursal" v-for="sucursal in sucursales" :key="sucursal.id">@{{sucursal.name}} | @{{sucursal.direccion}}</option>
        </select>

        <label for="sucursal">Elegir sucursal</label>
      </fieldset>
    </div>

    <span v-if="sucursale_elegida != ''">

      <span v-if="!cargando">
        <div v-if="clases_para_reservar.length > 0" class="w-100 p-2">

          <div class="h5  mb-4 ">
            Elegí la clase que quieres reservar <i class="fas fa-hand-point-down"></i>
          </div>

          <div v-if="dia.clases.length > 0" v-for="dia in clases_para_reservar" :key="dia.day_text" class="px-2 mb-5">

            <div class="h5 mb-0">
             <b>Clases del día @{{dia.day_text}}</b>
            </div>

            <div class="mx-0 row border-radius-estandar p-3  col-12 col-lg-7">
                <clase :clase="clase"
                       @reservo="getClasesParaReservar(false)"
                       :actividades="actividades"
                       :sucursal="sucursale_elegida"
                       :fecha="dia.day_text"
                       :dia="dia.day.date"
                       :reservas_del_dia_del_socio="dia.reservas_del_dia_del_socio"
                       :socio_id="dia.socio_id"
                       v-for="clase in dia.clases"
                       :key="dia.day_text + ' ' + clase.id"></clase>
            </div>

          </div>

        </div>
        <div v-else class=" col-12 text-center h3">
          No es posible reservar ahora. Intentá en unas horas o mañana.
        </div>
      </span>
      <div v-else class="my-5  Procesando-text w-100">
        <div class="cssload-container">
            <div class="cssload-tube-tunnel"></div>
        </div>
      </div>
    </span>



  </div>

`,
};
