var avisoItem = {
  props: ["aviso", "admin"],

  data: function() {
    return {
      confirmando_lectura: false,
      empresa_id: this.$root.empresa.id,
      mostrar: true,
      borrando: false
    };
  },

  methods: {
    confirmarLectura: function() {
      var url = "/confirmar_lectura_de_aviso";
      var vue = this;

      vue.confirmando_lectura = true;

      let data = { empresa_id: this.empresa_id, aviso_id: this.aviso.id };
      axios
        .post(url, data)
        .then(function(response) {
          var data = response.data;

          if (data.Validacion == true) {
            vue.$emit("actualizar");
            vue.confirmando_lectura = false;
          } else {
            vue.confirmando_lectura = false;
          }
        })
        .catch(function(error) {
          vue.confirmando_lectura = false;
        });
    },
    delet: function() {
      var url = "/borrar_aviso";
      var vue = this;

      vue.borrando = true;

      let data = { empresa_id: this.empresa_id, aviso_id: this.aviso.id };
      axios
        .post(url, data)
        .then(function(response) {
          var data = response.data;

          if (data.Validacion == true) {
            vue.$emit("actualizar");
            vue.borrando = false;
          } else {
            vue.borrando = false;
          }
        })
        .catch(function(error) {
          vue.borrando = false;
        });
    }
  },
  computed: {
    classTypeText: function() {
      var success = this.aviso.type == "success" ? "text-success" : "";
      var error = this.aviso.type == "error" ? "text-danger " : "";
      var info = this.aviso.type == "info" ? "text-info " : "";
      var warning = this.aviso.type == "warning" ? "text-warning " : "";

      var clase = `${success} ${error} ${info} ${warning}`;

      return clase;
    },
    classTypeBorder: function() {
      var success = this.aviso.type == "success" ? "border border-success" : "";
      var error = this.aviso.type == "error" ? "border border-danger" : "";
      var info = this.aviso.type == "info" ? " border border-info" : "";
      var warning =
        this.aviso.type == "warning" ? " border border-warning" : "";

      var clase = `${success} ${error} ${info} ${warning}`;

      return clase;
    }
  },

  template: `

<div v-if="mostrar" class="w-100 mb-2">

    <div class="p-2 background-hover-gris-0 border-radius-estandar" :class="classTypeBorder">
        <div class="h6 mb-2" :class="classTypeText">
            <strong>@{{aviso.title}}</strong>
        </div>
        <p class="color-text-gris mb-1">
          @{{aviso.text}}. <a :href="aviso.call_to_action_url" v-if="aviso.call_to_action_url != null || aviso.call_to_action_url != '' "> @{{aviso.call_to_action}}</a>
        </p>
        <div class="w-100 d-flex flex-row align-items-center space-between">
            <div class="col-8  px-1 helper-fuente-pequeña color-text-gris"  >
                <div v-if="aviso.leido == 'si'">
                    <div @click="confirmarLectura" class="color-text-gris">
                      <span class="text-success"><i class="fas fa-check-circle"></i></span>  Leido el @{{aviso.fecha_leido}} por @{{aviso.leido_por}}
                    </div>

                </div>
                <div v-else >
                   <span v-if="admin"> Sin leer aún     </span>
                </div>


                <span v-if="admin">
                  <span v-if="!borrando" @click="delet"><i class="fas fa-trash-alt"></i> Borrar</span>
                  <span v-else> Borrando...</span>


                </span>
            </div>
            <div class="col-4 px-1 d-flex flex-column align-items-end">
                <button :disabled="confirmando_lectura"  @click="confirmarLectura" type="button" class="btn btn-outline-info btn-sm cursor-pointer">Cerrar</button>
            </div>
        </div>
    </div>
</div>


`
};
