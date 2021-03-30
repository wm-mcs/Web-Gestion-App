@include('empresa_gestion_paginas.Vue_logica.Componentes.ConfiguracionEmpresas.Componentes.Agenda.lista')

Vue.component("listado", {

  components:{
    'Lista':ListaActividad
  },
  data: function () {
    return {
      cargando: false,
      entidades:[],
      showModal: false,
    };
  },
  methods: {


    get: function () {
      var url = "/get_agendas";

      var data = {empresa_id:this.$root.empresa.id};

      var vue = this;
      vue.cargando = true;

      axios
        .post(url, data)
        .then(function (response) {
          var data = response.data;

          if (data.Validacion == true) {
            vue.cargando = false;
            vue.entidades = data.Data;



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
  mounted: function () {

      this.get();
  },
  created() {
    bus.$on("se-creo-o-edito", data => {
        this.get();
    });

},

  template: `
  <div class="row mx-0 my-5 w-100">

    <div v-if="cargando" class="my-5  Procesando-text w-100">
        <div class="cssload-container">
            <div class="cssload-tube-tunnel"></div>
        </div>
    </div>

    <Lista  v-for="entidad in entidades" :entidad="entidad" :key="entidad.id" v-if="entidades.length > 0">
        @{{entidad.name}}
    </Lista>


  </div>

`,
});
