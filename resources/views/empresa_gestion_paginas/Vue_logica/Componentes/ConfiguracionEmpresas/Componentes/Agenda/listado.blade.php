@include('empresa_gestion_paginas.Vue_logica.Componentes.ConfiguracionEmpresas.Componentes.Agenda.lista')

Vue.component("listado", {
  mixins: [actividadeslMixIn],
  components: {
    Lista: Lista
  },
  data: function() {
    return {
      cargando: false,
      entidades: [],
      showModal: false,
      diasArrayObjeto: [
        {
          name: "lunes",
          valor: 1
        },
        {
          name: "martes",
          valor: 2
        },
        {
          name: "miércoles",
          valor: 3
        },
        {
          name: "jueves",
          valor: 4
        },
        {
          name: "viernes",
          valor: 5
        },
        {
          name: "sábado",
          valor: 6
        },
        {
          name: "domingo",
          valor: 0
        }
      ]
    };
  },
  methods: {
    get: function() {
      var url = "/get_agendas";

      var data = { empresa_id: this.$root.empresa.id };

      var vue = this;
      vue.cargando = true;

      axios
        .post(url, data)
        .then(function(response) {
          var data = response.data;

          if (data.Validacion == true) {
            vue.cargando = false;
            vue.entidades = data.Data;
          } else {
            vue.cargando = false;
            $.notify(response.data.Validacion_mensaje, "error");
          }
        })
        .catch(function(error) {
          vue.cargando = false;
          $.notify("Upsssssss.. algo pasó", "error");
        });
    }
  },
  computed: {
    diasConAgendasArray: function() {
      let dataConDias = [];

      this.diasArrayObjeto.forEach((dia) => {
        let agendasDeesteDia = this.entidades
          .filter((agenda) => {
            return agenda.days.split(",").includes(dia.valor.toString());
          })
          .sort(function(a, b) {
            a = parseInt(a.hora_inicio.replace(":", ""));
            b = parseInt(b.hora_inicio.replace(":", ""));

            if (a > b) {
              return 1;
            }
            if (a < b) {
              return -1;
            }

            return 0;
          });

        dataConDias.push({
          name: dia.name,
          agendas: agendasDeesteDia
        });
      });

      return dataConDias;
    }
  },
  mounted: function() {
    this.get();
  },
  created() {
    bus.$on("se-creo-o-edito", (data) => {
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
    <div v-else class="row w-100 mx-0">

    <div v-for="diaObjeto in diasConAgendasArray" :key="diaObjeto.valor" class="col-12 col-lg-2 mb-2 p-2">
      <div class="p-1 border-hover-gris-0">


      <p class="w-100 px-2 mb-2">
        <b class="text-uppercase">@{{diaObjeto.name}}</b>
      </p>

      <div >
      <Lista  v-for="agenda in diaObjeto.agendas" :key="diaObjeto.name + '-' +agenda.id " :entidad="agenda" :actividades="actividades" v-if="diaObjeto.agendas.length > 0">

      </Lista>
      </div>
      </div>
    </div>


    </div>




  </div>

`
});
