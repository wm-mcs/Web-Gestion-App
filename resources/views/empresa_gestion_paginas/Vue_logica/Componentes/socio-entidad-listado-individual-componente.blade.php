Vue.component("socio-list", {
  props: ["socio", "empresa", "acceso"],
  data: function() {
    return {
      clases_desplegadas: false,
      mensuales_desplegadas: false,
      cargando: false
    };
  },
  methods: {
    enviar_form: function(id) {
      var id = "#" + id.toString();
      $(id)
        .parent()
        .submit();
    },
    abrir_cerrar_clases: function() {
      if (this.clases_desplegadas) {
        this.clases_desplegadas = false;
      } else {
        this.clases_desplegadas = true;
      }
    },
    abrir_cerrar_mensual: function() {
      if (this.mensuales_desplegadas) {
        this.mensuales_desplegadas = false;
      } else {
        this.mensuales_desplegadas = true;
      }
    },
    consumir_esta_clase: function(servicio) {
      var mensaje =
        "¿Seguro quieres consumir está clase? (de " + this.socio.name + " )";
      var validation = confirm(mensaje);
      if (!validation) {
        return "";
      }
      var url = "/indicar_que_se_uso_el_servicio_hoy";
      var vue = this;
      var data = {
        servicio_a_editar: servicio,
        socio_id: this.socio.id,
        servicio_id: servicio.id,
        empresa_id: this.empresa.id
      };
      this.cargando = true;
      axios
        .post(url, data)
        .then(function(response) {
          if (response.data.Validacion == true) {
            vue.cargando = false;
            vue.$emit("ActualizarSocios", response.data.Socios);
            $.notify(response.data.Validacion_mensaje, "success");
          } else {
            vue.cargando = false;
            $.notify(response.data.Validacion_mensaje, "warn");
          }
        })
        .catch(function(error) {});
    },
    cargar_servicios: function() {
      var mensaje =
        "¿Seguro quieres renovar los servicios? (de " + this.socio.name + " )";
      var validation = confirm(mensaje);
      if (!validation) {
        return "";
      }
      var url = "/cargar_servicios_recuerrentes_a_socio";
      var vue = this;
      var data = { socio_id: this.socio.id, empresa_id: this.empresa.id };
      axios
        .post(url, data)
        .then(function(response) {
          if (response.data.Validacion == true) {
            vue.$emit("ActualizarSocios", response.data.Socios);
            $.notify(response.data.Validacion_mensaje, "success");
          } else {
            $.notify(response.data.Validacion_mensaje, "warn");
          }
        })
        .catch(function(error) {});
    }
  },
  computed: {
    desactivado: function() {
      if (this.socio.estado != "si") {
        return true;
      } else {
        return false;
      }
    },
    clasesDisponibles: function() {
      if (this.socio.servicios_contratados_disponibles_tipo_clase.length > 0) {
        return true;
      } else {
        return false;
      }
    },
    mensualDisponibles: function() {
      if (
        this.socio.servicios_contratados_disponibles_tipo_mensual.length > 0
      ) {
        return true;
      } else {
        return false;
      }
    },
    nadaDisponible: function() {
      if (this.clasesDisponibles || this.mensualDisponibles) {
        return false;
      } else {
        return true;
      }
    },
    cantidadDeClasesDisponibles: function() {
      var cantidad = this.socio.servicios_contratados_disponibles_tipo_clase
        .length;
      if (cantidad > 0) {
        if (cantidad > 1) {
          return cantidad + " clases disponibles";
        } else {
          return cantidad + " clase disponible";
        }
      } else {
        return 0;
      }
    },
    cantidadDeMensualesDisponibles: function() {
      var cantidad = this.socio.servicios_contratados_disponibles_tipo_mensual
        .length;
      if (cantidad > 0) {
        if (cantidad > 1) {
          return cantidad + " mensuales disponibles";
        } else {
          return cantidad + " mensual disponible";
        }
        return cantidad;
      } else {
        return 0;
      }
    },
    getClassLista: function() {
      var saldo_pesos = this.socio.saldo_de_estado_de_cuenta_pesos;
      var saldo_dolares = this.socio.saldo_de_estado_de_cuenta_dolares;
      if (saldo_pesos < 0 || saldo_dolares < 0) {
        var debe = true;
      } else {
        var debe = false;
      }
      return {
        "contiene-socio-tipo-lista": true
      };
    },
    mostrarEstadoDeCuenta: function() {
      if (this.nadaDisponible) {
        if (
          this.socio.saldo_de_estado_de_cuenta_dolares != 0 ||
          this.socio.saldo_de_estado_de_cuenta_pesos != 0
        ) {
          return true;
        } else {
          return false;
        }
      } else {
        return true;
      }
    },
    tieneServiciosRenovacion: function() {
      if (this.socio.servicios_renovacion_del_socio.length) {
        return true;
      } else {
        return false;
      }
    },
    whatsAppLink: function() {
      var celular = `${this.$root.empresa.pais_object.cell_phone_code}${
        this.socio.celular.charAt(0) == "0"
          ? this.socio.celular.substr(1)
          : this.socio.celular
      }`;

      var url = "https://api.whatsapp.com/send?phone=" + celular + "&text=Hola";
      return url;
    },
    whatsAppnumero: function() {
      if (
        this.socio.celular_internacional == "" ||
        this.socio.celular_internacional == null
      ) {
        return this.socio.celular;
      } else {
        return this.socio.celular_internacional;
      }
    }
  },
  template: `
<div class="w-100 row mx-0 align-items-center mb-3 p-3" :class="getClassLista">
  {!! Form::open([ 'route' => ['get_socio_panel'], 'method'=> 'Post', 'files' =>
  true, 'class' => 'col-6 col-lg-5 d-flex align-items-center mx-0 px-0
  mb-lg-0' ]) !!}

  <input type="hidden" name="empresa_id" :value="empresa.id" />
  <span :id="socio.id" class="no-mostrar"></span>
  <input type="hidden" name="socio_id" :value="socio.id" />

  <div class="mr-3">
    <img class="socio-img  " :src="socio.url_img" />
  </div>
  <div class="">
    <span
      class="contiene-socio-lista d-block"
      v-on:click="enviar_form(socio.id)"
      >@{{ socio.name }}</span
    >
    <a :href="whatsAppLink" target="_blank">
      <div class="contiene-socio-celular">
        <i class="fab fa-whatsapp"></i> @{{ whatsAppnumero }}
      </div>
    </a>
  </div>

  {!! Form::close() !!}

  <div class="col-6 col-lg-7 ">
    <div class="w-100 d-flex flex-column align-items-end">
      <div v-if="nadaDisponible" class="color-text-gris text-right datos-socio-lista mb-2">
         <i class="fas fa-times-circle"></i> Nada disponible
      </div>


      <div v-if="socio.nota != null &&  socio.nota != ''" class="color-text-gris text-right datos-socio-lista mb-2">
      <i class="fas fa-exclamation"></i> @{{socio.nota}}
      </div>
      <div
        v-if="clasesDisponibles"
        class="color-text-clases text-right datos-socio-lista mb-2"
      >
        <span class="cursor-pointer">

        <i class="fas fa-check-circle"></i>
          <span v-if="clases_desplegadas" v-on:click="abrir_cerrar_clases">
            Tiene <strong>@{{ cantidadDeClasesDisponibles }}</strong>
            <i class="fas fa-chevron-up"></i>
          </span>
          <span v-else v-on:click="abrir_cerrar_clases">
            Tiene <strong>@{{ cantidadDeClasesDisponibles }}</strong>
            <i class="fas fa-chevron-down"></i
          ></span>
        </span>

        <transition name="fade">
          <div
            v-if="clases_desplegadas"
            class=" my-2 p-1 borde-gris background-gris-0"
          >
            <div
              v-for="servicio in socio.servicios_contratados_disponibles_tipo_clase"
              :key="servicio.id"
              class="row mx-0 mb-2"
            >
              <div class="col-12 listado-socio-lista-servicio-disponible">
                <div class=" col-8 text-left">
                  @{{ servicio.name }}</div
                >
                <div v-if="cargando" class="col-4 Procesando-text">
                  <div class="cssload-container">
                    <div class="cssload-tube-tunnel"></div>
                  </div>
                </div>
                <div
                  v-else
                  class="cursor-pointer col-4 listado-socio-lista-servicio-disponible-accion "
                  v-on:click="consumir_esta_clase(servicio)"
                  title="Indicar que el socio va a usar la clase ahora."
                >
                  Usar</div>
              </div>
            </div>
          </div>
          </transition>
      </div>


      <div
        v-if="mensualDisponibles"
        v-for="servicio in socio.servicios_contratados_disponibles_tipo_mensual"
        class="color-text-mensual text-right datos-socio-lista mb-2"
        :key="servicio.id"
      >
      <i class="fas fa-check-circle"></i>
        <span>@{{ servicio.name }}</span>
        <strong class="plan-mensual-fecha-vencimiento"
          >Vence: @{{ servicio.fecha_vencimiento_formateada }}</strong
        >
      </div>

      <div class="w-100">
        <estado-de-cuenta-socio-saldo
          v-if="mostrarEstadoDeCuenta"
          :empresa="empresa"
          :socio="socio"
        >
        </estado-de-cuenta-socio-saldo>

        <p
          class="color-text-gris mt-2 mb-0"
          v-if="acceso != null && acceso != undefined"
        >
          <small>@{{ acceso.fecha_formateada }}</small>
        </p>
      </div>
    </div>
  </div>
</div>

`
});
