@include('empresa_gestion_paginas.Vue_logica.Componentes.tipoServicioEmpresa.cantidadDeDiasArray')
Vue.component("crear-servicios", {
  mixins: [onKeyPressEscapeCerrarModalMixIn],
  data: function () {
    return {
      cargando: false,
      datos_a_enviar: {
        name: "",
        empresa_id: this.$root.empresa.id,
        moneda:  '$',
        valor:'',
        tipo:'',
        cantidad_clases:0,
        renovacion_cantidad_en_dias:30,

        estado: "si",
      },
      array_cantidad_de_dias:cantidadDeDiasArray,
      showModal: false,
    };
  },
  methods: {
    limpiar_data_crear: function () {
      this.datos_a_enviar = {
        name: "",
        moneda:  '$',
        valor:'',
        tipo:'',
        cantidad_clases:0,
        renovacion_cantidad_en_dias:30,

        estado: "si",

      };
    },

    crear: function () {
      var url = "/set_nuevo_servicio";

      var data = this.datos_a_enviar;

      var vue = this;

      axios
        .post(url, data)
        .then(function (response) {
          var data = response.data;

          if (data.Validacion == true) {
            vue.cargando = false;
            bus.$emit("se-creo-actividad", "hola");
            vue.showModal = false;
            vue.limpiar_data_crear();
            $.notify(response.data.Validacion_mensaje, "success");
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
  mounted: function () {},

  template: `<span>


  <button type="button" class="Boton-Fuente-Chica Boton-Primario-Relleno " @click="showModal = true">
   Crear <i class="fas fa-plus"></i>
  </button>


  <transition name="modal" v-if="showModal">
    <div class="modal-mask ">
      <div class="modal-wrapper">
        <div class="modal-container position-relative">
        <span class="modal-cerrar-icono sub-titulos-class text-center color-text-gris" @click="showModal = !showModal">
          <i class="fas fa-times"></i>
        </span>


          <div class="row">
            <h4 class="col-12 sub-titulos-class" > Crear nuevo servicio</h4>
            <div class="col-12 modal-mensaje-aclarador">
            Existen dos tipos de servicios mensual y por clase.
              <b>Mensula</b>  significa que no se controla la cantidad de veces que el socio asiste. Ejemplo de mensual sería un pase libre.
              <b>Clase</b>  sería para el caso de una cuponera. Cada vez que el socio toma una clase se descontará de la cuponera.
              En ambos caso tiene vencimientos y estos podrán ser editados.
            </div>
          </div>

          <div class="modal-body">

            <div class="row  mx-0 ">


                <div class="formulario-label-fiel">
                  <fieldset class="float-label">
                    <input
                      name="name"
                      type="text"
                      class="input-text-class-primary"
                      v-model="datos_a_enviar.name"
                      required

                    />
                    <label for="name">Nombre</label>
                  </fieldset>
                </div>
                <div class="formulario-label-fiel">
                  <fieldset class="float-label">
                  <select  name="tipo" required v-model="datos_a_enviar.tipo" class="input-text-class-primary">
                      <option>clase</option>
                      <option>mensual</option>
                  </select>
                    <label for="tipo">¿Por clase o mensual?</label>
                  </fieldset>
                </div>





                <div v-if="datos_a_enviar.tipo == 'clase'" class="formulario-label-fiel">
                  <fieldset class="float-label">
                    <input
                      name="cantidad_clases"
                      type="nimber"
                      class="input-text-class-primary"
                      v-model="datos_a_enviar.cantidad_clases"
                      required
                      step="any"

                    />
                    <label for="cantidad_clases">Cantidad de clases <span class="text-muted"> ¿Cuántas clases tiene la cuponera? </span></label>
                  </fieldset>
                </div>

                <div v-if="$root.aceptaDolares" class="col-12 col-lg-4 formulario-label-fiel">
                  <label class="formulario-label">¿Pesos o Dolares?</label>
                  <select v-model="datos_a_enviar.moneda" class="formulario-field">
                    <option>$</option>
                    <option>U$S</option>
                  </select>
                </div>

                <div v-if="datos_a_enviar.tipo == 'mensual' || datos_a_enviar.cantidad_clases > 0 " class="formulario-label-fiel">
                  <fieldset class="float-label">
                    <input
                      name="valor"
                      type="nomber"
                      class="input-text-class-primary"
                      v-model="datos_a_enviar.valor"
                      required
                      step="any"

                    />
                    <label for="valor">¿Cuánto cuesta?  <span v-if="datos_a_enviar.tipo == 'clase' " >   El valor total de las <b> @{{datos_a_enviar.cantidad_clases}} clases </b> </span> </label>
                  </fieldset>
                </div>


                <div class="formulario-label-fiel">
                  <fieldset class="float-label">

                  <select name="renovacion_cantidad_en_dias" required v-model="datos_a_enviar.renovacion_cantidad_en_dias" class="formulario-field">
                    <option v-for="cantidad_dias in array_cantidad_de_dias" :value="cantidad_dias.cantidad_de_dias_numero">
                      @{{cantidad_dias.cantidad_de_dias_texto}}
                    </option>
                  </select>
                    <label for="renovacion_cantidad_en_dias">Se vence en</label>
                  </fieldset>
                </div>



                <div class="formulario-label-fiel">
                  <fieldset class="float-label">

                  <select  name="estado" required v-model="datos_a_enviar.estado" class="formulario-field">
                  <option>si</option>
                  <option>no</option>
                </select>
                    <label for="estado">¿Activo?</label>
                  </fieldset>
                </div>









              <h5 class="text-center col-12 my-4"  v-if="datos_a_enviar.tipo == 'clase' && datos_a_enviar.cantidad_clases < 1 ">
                  La cantidad de clases debe ser mayor a 0.
              </h5>
              <button v-else type="button" @click="crear" class="mt-4 Boton-Fuente-Chica Boton-Primario-Sin-Relleno">
                 Confirmar
              </button>
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
</span>

`,
});
